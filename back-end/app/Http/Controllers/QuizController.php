<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function indexForCandidat(Request $request)
    {
        $quizzes = Quiz::where('permis_type', $request->user()->permis_type)
                      ->withCount('questions')
                      ->get();
        
        return view('candidat.quizzes.index', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'permis_type' => 'required|in:A,B,C,D,EB,A1,A2,B1,C1,D1,BE,C1E,D1E',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Quiz::create([
            'admin_id' => Auth::id(),
            'permis_type' => $validated['permis_type'],
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz créé avec succès');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'permis_type' => 'required|in:A,B,C,D,EB,A1,A2,B1,C1,D1,BE,C1E,D1E',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz mis à jour avec succès');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz supprimé avec succès');
    }

    public function showForCandidat(Quiz $quiz)
    {
        return view('candidat.quizzes.show', compact('quiz'));
    }
}