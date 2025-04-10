<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Choice;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        Gate::authorize('create', Answer::class);

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => [
                'required',
                'exists:questions,id,quiz_id,'.$quiz->id
            ],
            'answers.*.choice_id' => [
                'required',
                Rule::exists('choices', 'id')->where(function ($query) use ($request) {
                    $query->whereIn('question_id', array_column($request->answers, 'question_id'));
                })
            ]
        ]);

        try {
            DB::beginTransaction();

            $results = [];
            $totalScore = 0;
            $totalQuestions = $quiz->questions()->count();

            foreach ($validated['answers'] as $answer) {
                $choice = Choice::find($answer['choice_id']);
                $isCorrect = $choice->is_correct;

                $answer = Answer::updateOrCreate(
                    [
                        'candidat_id' => Auth::id(),
                        'question_id' => $answer['question_id']
                    ],
                    [
                        'choice_id' => $answer['choice_id'],
                        'is_correct' => $isCorrect
                    ]
                );

                $results[] = [
                    'question_id' => $answer['question_id'],
                    'is_correct' => $isCorrect,
                    'choice_id' => $answer['choice_id']
                ];

                if ($isCorrect) {
                    $totalScore++;
                }
            }

            DB::commit();

            session()->flash('quiz_results', [
                'score' => [
                    'total' => $totalScore,
                    'max' => $totalQuestions,
                    'percentage' => round(($totalScore/$totalQuestions)*100, 2)
                ],
                'results' => $results
            ]);

            return redirect()->route('quiz.results', $quiz);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Échec de soumission des réponses: ' . $e->getMessage());
        }
    }

    public function getResults(Quiz $quiz)
    {
        $user = Auth::user();

        Gate::authorize('view-results', [$quiz, $user]);

        $answers = Answer::with(['question', 'choice'])
            ->where('candidat_id', $user->id)
            ->whereHas('question', function($q) use ($quiz) {
                $q->where('quiz_id', $quiz->id);
            })
            ->get();

        $totalQuestions = $quiz->questions()->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        
        $scoreData = [
            'correct' => $correctAnswers,
            'total' => $totalQuestions,
            'percentage' => $totalQuestions > 0 ? round(($correctAnswers/$totalQuestions)*100, 2) : 0
        ];
        
        $answerData = $answers->map(function($answer) {
            return [
                'question_id' => $answer->question_id,
                'choice_id' => $answer->choice_id,
                'is_correct' => $answer->is_correct,
                'question_text' => $answer->question->question_text,
                'choice_text' => $answer->choice->choice_text
            ];
        });

        return view('quiz.results', compact('quiz', 'scoreData', 'answerData'));
    }
}