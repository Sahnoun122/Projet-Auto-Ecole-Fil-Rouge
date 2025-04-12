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

        return view('admin.questions', compact('quiz', 'questions'));
    }

    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
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

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question ajoutée avec succès!');
    }

    public function show(Quiz $quiz, Question $question)
    {
        $question->load('choices');
        return view('admin.questions.show', compact('quiz', 'question'));
    }

    public function edit(Quiz $quiz, Question $question)
    {
        $question->load('choices');
        return view('admin.questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question mise à jour avec succès!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question supprimée avec succès!');
    }

    public function details(Quiz $quiz, Question $question)
    {
        $question->load(['choices', 'quiz']);
        
        return response()->json([
            'html' => view('admin.questions.partials.details_modal_content', [
                'quiz' => $quiz,
                'question' => $question
            ])->render()
        ]);
    }
}