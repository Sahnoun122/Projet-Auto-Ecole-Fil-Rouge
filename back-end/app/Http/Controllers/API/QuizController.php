<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('admin.AjouterQuiz', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create([
            // 'admin_id' => Auth::id(), 
            'admin_id' => 2, 

            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return view('admin.AjouterQuiz', ['quizzes' => Quiz::all()]);
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($validated);

        return view('admin.AjouterQuiz', ['quizzes' => Quiz::all()]);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return view('admin.AjouterQuiz', ['quizzes' => Quiz::all()]);
    }
}