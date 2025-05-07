<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; 
use Illuminate\Support\Facades\Log; 

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
    public function store(Request $request, Quiz $quiz)
    {
        
        $imagePath = "";

        $validated = $request->validate([
            'question_text' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'required|integer|min:5|max:30',
            'choices' => 'required|array|min:2|max:5',
            'choices.*.text' => 'required|string|max:255',
            'correct_choice' => 'required|integer'
        ]);

        // dd($request);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = $quiz->questions()->create([
            'admin_id' =>  Auth::id(),
            'question_text' => $validated['question_text'],
            'image_path' => $imagePath,
            'duration' => $validated['duration'],
        ]);

        foreach ($validated['choices'] as $index => $choiceData) {
            $question->choices()->create([
                'admin_id' =>  Auth::id() ,
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
            'question_text' => 'sometimes|string|max:1000|nullable',
            'remove_image' => 'nullable|boolean',
            'duration' => 'nullable|integer|min:5|max:300',
            'choices' => 'nullable|array|min:2|max:5',
            'choices.*.id' => 'nullable|integer',
            'choices.*.text' => 'nullable|string|max:255',
            'correct_choice' => 'nullable|integer'
        ]);

        $updatePayload = [];
        if (array_key_exists('question_text', $validated)) {
            $updatePayload['question_text'] = $request->input('question_text');
        }
        if (array_key_exists('duration', $validated)) {
            $updatePayload['duration'] = $request->input('duration');
        }
        if ($request->input('remove_image') == '1') {
            if ($question->image_path) {
                Storage::disk('public')->delete($question->image_path);
                $updatePayload['image_path'] = null;
            }
        }
        if (!empty($updatePayload)) {
            $question->update($updatePayload);
        }

        $existingChoiceIds = [];
        if (isset($validated['choices'])) {
            foreach ($validated['choices'] as $index => $choiceData) {
                $choiceText = Arr::get($choiceData, 'text');
                if ($choiceText === null || $choiceText === '') continue;
                $isCorrect = isset($validated['correct_choice']) && $index == $validated['correct_choice'];
                $choiceId = Arr::get($choiceData, 'id');
                if ($choiceId) {
                    $choice = $question->choices()->find($choiceId);
                    if ($choice) {
                        $choice->update([
                            'choice_text' => $choiceText,
                            'is_correct' => $isCorrect
                        ]);
                        $existingChoiceIds[] = $choice->id;
                    }
                } else {
                    $newChoice = $question->choices()->create([
                        'admin_id' => Auth::id(),
                        'choice_text' => $choiceText,
                        'is_correct' => $isCorrect
                    ]);
                    $existingChoiceIds[] = $newChoice->id;
                }
            }
            $question->choices()->whereNotIn('id', $existingChoiceIds)->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Question mise à jour avec succès!',
            'question' => $question->fresh('choices')
        ]);
    }

    public function updateImage(Request $request, Question $question)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }
        $imagePath = $request->file('image')->store('questions', 'public');
        $question->update(['image_path' => $imagePath]);
        return response()->json([
            'success' => true,
            'message' => 'Image mise à jour avec succès!',
            'image_path' => $imagePath,
            'image_url' => asset('storage/' . $imagePath)
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

    public function showDetails(Question $question)
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