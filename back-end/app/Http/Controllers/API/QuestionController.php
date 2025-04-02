<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function store(Request $request, $quizId)
    {
        $request->validate([
            'question_text' => 'required|string',
            'image_path' => 'nullable|string',
        ]);

        $question = Question::create([
            'quiz_id' => $quizId,
            'admin_id' => Auth::id(), 
            'question_text' => $request->question_text,
            'image_path' => $request->image_path,
        ]);

        return response()->json($question, 201); 
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'question_text' => 'required|string',
            'image_path' => 'nullable|string',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'image_path' => $request->image_path,
        ]);

        return response()->json($question);
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json([
            'message' => 'Question deleted successfully.'
        ], 200);
    }
}