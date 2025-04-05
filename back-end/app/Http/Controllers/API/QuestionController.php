<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    public function store(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        Gate::authorize('create', Question::class); 

        $validated = $request->validate([
            'question_text' => 'required|string',
            'image_path' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        $question = $quiz->questions()->create([
            'admin_id' => Auth::id(),
            'question_text' => $validated['question_text'],
            'image_path' => $validated['image_path'],
            'duration' => $validated['duration'],
        ]);

        return response()->json($question, 201);
    }

    public function update(Request $request, Question $question)
    {
        Gate::authorize('update', $question); 

        $validated = $request->validate([
            'question_text' => 'sometimes|string',
            'image_path' => 'nullable|string',
            'duration' => 'sometimes|integer|min:1',
        ]);

        $question->update($validated);

        return response()->json($question);
    }

    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);

        $question->delete();
        return response()->json(['message' => 'Question deleted successfully.'], 200);
    }
}
