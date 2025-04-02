<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('admin')->get();
        return response()->json($quizzes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create([
            'admin_id' => Auth::id(),  
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($quiz, 201);
    }

    public function show($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        return response()->json($quiz);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully.'], 200);
    }
}
