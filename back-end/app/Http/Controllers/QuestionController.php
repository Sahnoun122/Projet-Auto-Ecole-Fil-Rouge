<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()
            ->with(['choices' => function($query) {
                $query->orderBy('is_correct', 'desc')->orderBy('id');
            }])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.questions.index', compact('quiz', 'questions'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'required|integer|min:5|max:300',
            'choices' => 'required|array|min:2|max:5',
            'choices.*.text' => 'required|string|max:255',
            'correct_choice' => 'required|integer'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = $quiz->questions()->create([
            'admin_id' => Auth::id(),
            'question_text' => $validated['question_text'],
            'image_path' => $imagePath,
            'duration' => $validated['duration'],
        ]);

        foreach ($validated['choices'] as $index => $choiceData) {
            $question->choices()->create([
                'admin_id' => Auth::id(),
                'choice_text' => $choiceData['text'],
                'is_correct' => $index == $validated['correct_choice']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Question ajoutée avec succès!',
            'question' => $question->load('choices')
        ]);
    }

    public function edit(Question $question)
    {
        $question->load('choices');
        return response()->json([
            'question' => $question,
            'choices' => $question->choices
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'nullable|boolean',
            'duration' => 'required|integer|min:5|max:300',
            'choices' => 'required|array|min:2|max:5',
            'choices.*.id' => 'nullable|integer',
            'choices.*.text' => 'required|string|max:255',
            'correct_choice' => 'required|integer'
        ]);

        $imagePath = $question->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('questions', 'public');
        } elseif ($request->remove_image) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
                $imagePath = null;
            }
        }

        $question->update([
            'question_text' => $validated['question_text'],
            'image_path' => $imagePath,
            'duration' => $validated['duration'],
        ]);

        $existingChoiceIds = [];
        
        foreach ($validated['choices'] as $index => $choiceData) {
            if (isset($choiceData['id'])) {
                $choice = $question->choices()->find($choiceData['id']);
                if ($choice) {
                    $choice->update([
                        'choice_text' => $choiceData['text'],
                        'is_correct' => $index == $validated['correct_choice']
                    ]);
                    $existingChoiceIds[] = $choice->id;
                }
            } else {
                $newChoice = $question->choices()->create([
                    'admin_id' => Auth::id(),
                    'choice_text' => $choiceData['text'],
                    'is_correct' => $index == $validated['correct_choice']
                ]);
                $existingChoiceIds[] = $newChoice->id;
            }
        }

        $question->choices()->whereNotIn('id', $existingChoiceIds)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question mise à jour avec succès!',
            'question' => $question->fresh('choices')
        ]);
    }

    public function destroy(Question $question)
    {
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question supprimée avec succès!'
        ]);
    }

    public function details(Question $question)
    {
        $question->load(['choices', 'quiz']);
        
        return response()->json([
            'question' => [
                'id' => $question->id,
                'quiz_id' => $question->quiz_id,
                'question_text' => $question->question_text,
                'image_url' => $question->image_path ? asset('storage/'.$question->image_path) : null,
                'duration' => $question->duration,
                'choices' => $question->choices->map(function($choice, $index) {
                    return [
                        'id' => $choice->id,
                        'choice_text' => $choice->choice_text,
                        'is_correct' => (bool)$choice->is_correct,
                        'index' => $index
                    ];
                })
            ]
        ]);
    }
}