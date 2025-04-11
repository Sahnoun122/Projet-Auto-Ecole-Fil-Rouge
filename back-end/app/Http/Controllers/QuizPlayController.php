<?php



namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuizPlayController  extends Controller
{
    public function show(Quiz $quiz)
    {
        Gate::authorize('play', $quiz);
        
        $questions = $quiz->questions()->with('choices')->get();
        
        return view('quiz.play', compact('quiz', 'questions'));
    }
}