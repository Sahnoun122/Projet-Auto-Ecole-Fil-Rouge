<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;



class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->get();
        return view('admin.quizzes', compact('quizzes'));
    }

    public function indexForCandidat(Request $request)
    {
        $quizzes = Quiz::where('permis_type', $request->user()->permis_type)
                      ->withCount('questions')
                      ->get();
        
        return view('candidat.quizzes', compact('quizzes'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'permis_type' => 'required|in:A,B,C,D,EB,A1,A2,B1,C1,D1,BE,C1E,D1E',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Quiz::create([
            'admin_id' => 1,
            'permis_type' => $validated['permis_type'],
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz créé avec succès');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'permis_type' => 'required|in:A,B,C,D,EB,A1,A2,B1,C1,D1,BE,C1E,D1E',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz mis à jour avec succès');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes')->with('success', 'Quiz supprimé avec succès');
    }

    public function showForCandidat(Quiz $quiz)
    {
        return view('candidat.quizzes.show', compact('quiz'));
 
   }
   public function startQuiz(Quiz $quiz)
   {
       $user = Auth::user();
   
       if ($quiz->permis_type !== $user->permis_type) {
           abort(403); 
       }
   
       Answer::where('candidat_id', $user->id)
           ->whereHas('question', function ($query) use ($quiz) {
               $query->where('quiz_id', $quiz->id);
           })
           ->delete();
   
       $firstQuestion = $quiz->questions()->orderBy('id')->first();
   
       if (!$firstQuestion) {
           return back()->with('error', 'Ce quiz ne contient aucune question');
       }
   
       return redirect()->route('candidat.quizzes.questions.show', [
           'quiz' => $quiz->id,
           'question' => $firstQuestion->id
       ]);
   }

   public function showQuestion(Quiz $quiz, Question $question)
   {
       if ($question->quiz_id !== $quiz->id || 
           $quiz->permis_type !== Auth::user()->permis_type) {
           abort(403);
       }
   
       $totalQuestions = $quiz->questions()->count();
       $currentPosition = $quiz->questions()->where('id', '<=', $question->id)->count();
       
       $choices = $question->choices()
                   ->orderBy('is_correct', 'desc')
                   ->orderBy(DB::raw('RAND()'))
                   ->get();
   
       return view('candidat.quizzes.show', compact('quiz', 'question', 'choices', 'totalQuestions', 'currentPosition'));
   }
   
   public function submitAnswer(Request $request, Quiz $quiz, Question $question)
   {
       if ($question->quiz_id !== $quiz->id || 
           $quiz->permis_type !== Auth::user()->permis_type) {
           abort(403);
       }

       $validated = $request->validate([
           'choice_id' => 'required|exists:choices,id,question_id,'.$question->id
       ]);
   
       $choice = Choice::find($validated['choice_id']);
       
       Answer::updateOrCreate(
           [
               'candidat_id' => Auth::id(),
               'question_id' => $question->id
           ],
           [
               'choice_id' => $choice->id,
               'is_correct' => $choice->is_correct
           ]
       );
   
       $nextQuestion = $quiz->questions()
                       ->where('id', '>', $question->id)
                       ->orderBy('id')
                       ->first();
   
       if ($nextQuestion) {
           return redirect()->route('candidat.quizzes.questions.show', [
               'quiz' => $quiz,
               'question' => $nextQuestion
           ]);
       }
   
       return redirect()->route('candidat.quizzes.results', $quiz);
   }
   
   public function showResults(Quiz $quiz)
   {
       if ($quiz->permis_type !== Auth::user()->permis_type) {
           abort(403);
       }
   
       $answers = Answer::with(['question', 'choice'])
           ->where('candidat_id', Auth::id())
           ->whereHas('question', function($query) use ($quiz) {
               $query->where('quiz_id', $quiz->id);
           })
           ->get();
   
       $totalQuestions = $quiz->questions()->count();
       $correctAnswers = $answers->where('is_correct', true)->count();
       $passed = $correctAnswers >= 32; 
   
       return view('candidat.quizzes.results', compact(
           'quiz', 'answers', 'totalQuestions', 'correctAnswers', 'passed'
       ));
   }
   

}