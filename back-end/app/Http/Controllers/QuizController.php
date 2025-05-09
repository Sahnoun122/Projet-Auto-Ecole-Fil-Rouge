<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;
use App\Models\User;




class QuizController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'quizzes');
        $search = $request->input('search');
        
        $quizzes = Quiz::when($search, function($query) use ($search) {
                        return $query->where('title', 'like', '%'.$search.'%')
                                    ->orWhere('description', 'like', '%'.$search.'%');
                    })
                    ->withCount('questions')
                    ->get();

        $passedQuizzes = Quiz::whereHas('questions.answers')
                            ->withCount('questions')
                            ->when($search, function($query) use ($search) {
                                return $query->where('title', 'like', '%'.$search.'%')
                                            ->orWhere('description', 'like', '%'.$search.'%');
                            })
                            ->get();

        return view('admin.quizzes', compact('quizzes', 'passedQuizzes', 'activeTab'));
    }


        public function indexForCandidat(Request $request)
        {
            $user = Auth::user();
            $typePermis = $user->type_permis;
            $activeTab = $request->get('tab', 'quizzes');
            
            $search = $request->input('search');
            
            $quizzes = Quiz::where('type_permis', $typePermis)
                           ->when($search, function($query) use ($search) {
                               return $query->where('title', 'like', '%'.$search.'%')
                                           ->orWhere('description', 'like', '%'.$search.'%');
                           })
                           ->withCount('questions')
                           ->get();
            
                    $passedQuizzes = Quiz::where('type_permis', $typePermis)
                    ->whereHas('questions.answers', function($query) use ($user) {
                        $query->where('candidat_id', $user->id);
                    })
                    ->with(['questions' => function($query) use ($user) {
                        $query->with(['answers' => function($query) use ($user) {
                            $query->where('candidat_id', $user->id)
                                ->with('choice');
                        }]);
                    }])
                    ->withCount(['questions', 
                        'questions as correct_answers_count' => function($query) use ($user) {
                            $query->whereHas('answers', function($query) use ($user) {
                                $query->where('candidat_id', $user->id)
                                    ->whereHas('choice', function($q) {
                                        $q->where('is_correct', true);
                                    });
                            });
                        }
                    ])
                    ->get()
                    ->map(function($quiz) {
                        $quiz->score = $quiz->correct_answers_count;
                        $quiz->total_questions = $quiz->questions_count;
                        $quiz->passed = $quiz->score >= Quiz::PASSING_SCORE;
                        return $quiz;
                    });
            return view('candidats.quizzes', compact('quizzes', 'passedQuizzes', 'typePermis', 'activeTab'));
        }
    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_permis' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);


        Quiz::create([
            'admin_id' => Auth::id(),
            'type_permis' => $validated['type_permis'],
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz créé avec succès');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'type_permis' => 'required',
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




public function prepareQuiz(Quiz $quiz)
{
    $user = Auth::user();
    
    if ($quiz->type_permis !== $user->type_permis) {
        abort(403);
    }

    return view('candidats.prepare', compact('quiz'));
}



    public function showForCandidat(Quiz $quiz)
    {
        return view('candidats.quizzes.show', compact('quiz'));
 
   }

   public function startQuiz(Quiz $quiz)
   {
       $user = Auth::user();
   
       if ($quiz->type_permis !== $user->type_permis) {
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
   
       return redirect()->route('candidats.questions', [
           'quiz' => $quiz->id,
           'question' => $firstQuestion->id
       ]);
   }


   public function showQuestion(Quiz $quiz, Question $question)
   {
       if ($question->quiz_id !== $quiz->id || 
           $quiz->type_permis !== Auth::user()->type_permis) {
           abort(403);
       }
   
       $totalQuestions = $quiz->questions()->count();
       $currentPosition = $quiz->questions()->where('id', '<=', $question->id)->count();
       
       $choices = $question->choices()
                   ->orderBy('is_correct', 'desc')
                   ->orderBy(DB::raw('RAND()'))
                   ->get();
   
       return view('candidats.questions', compact('quiz', 'question', 'choices', 'totalQuestions', 'currentPosition'));
   }
   
   public function submitAnswer(Request $request, Quiz $quiz, Question $question)
   {
       if ($question->quiz_id !== $quiz->id || 
           $quiz->type_permis !== Auth::user()->type_permis) {
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
           return redirect()->route('candidats.questions', [
               'quiz' => $quiz,
               'question' => $nextQuestion
           ]);
       }
   
       return redirect()->route('candidats.results', $quiz);
   }
   


public function showResults(Quiz $quiz)
{
    $user = Auth::user();
    
    if ($quiz->type_permis !== $user->type_permis) {
        abort(403, "Vous n'avez pas accès à ces résultats");
    }

    $results = $quiz->getResults($user->id);

    if ($results['correct_answers'] + $results['wrong_answers'] > $results['total_questions']) {
        abort(500, "Incohérence dans les résultats du quiz");
    }

    return view('candidats.results', [
        'quiz' => $quiz,
        'results' => $results,
        'user' => $user
    ]);
}




    public function results(Quiz $quiz)
    {
        $candidates = User::where('role', 'candidat')
            ->whereHas('answers', function($query) use ($quiz) {
                $query->whereHas('question', function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
                });
            })
            ->withCount(['answers as correct_answers' => function($query) use ($quiz) {
                $query->whereHas('choice', function($q) {
                    $q->where('is_correct', true);
                })->whereHas('question', function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
                });
            }])
            ->with(['answers' => function($query) use ($quiz) {
                $query->whereHas('question', function($q) use ($quiz) {
                    $q->where('quiz_id', $quiz->id);
                })->with('question');
            }])
            ->paginate(10);

        return view('admin.results', [
            'quiz' => $quiz,
            'candidates' => $candidates,
            'totalQuestions' => $quiz->questions()->count()
        ]);
    }

    public function candidateResults(Quiz $quiz, User $candidate)
    {
        if ($candidate->role !== 'candidat') {
            abort(403, "Cet utilisateur n'est pas un candidat");
        }

        $results = $quiz->getResults($candidate->id);

        return view('admin.candidate-results', [
            'quiz' => $quiz,
            'candidate' => $candidate,
            'results' => $results
        ]);
    }
}



