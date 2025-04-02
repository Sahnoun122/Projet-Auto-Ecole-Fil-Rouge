<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Choice;
use App\Models\Quiz;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AnswerController extends Controller
{
  

    public function store(Request $request, $quizId)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => [
                'required',
                'exists:questions,id,quiz_id,'.$quizId
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
            $totalQuestions = Question::where('quiz_id', $quizId)->count();

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

            return response()->json([
                'message' => 'Answers submitted successfully',
                'score' => [
                    'total' => $totalScore,
                    'max' => $totalQuestions,
                    'percentage' => round(($totalScore/$totalQuestions)*100, 2)
                ],
                'results' => $results
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to submit answers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getResults($quizId)
    {
        $answers = Answer::with(['question', 'choice'])
            ->where('candidat_id', Auth::id())
            ->whereHas('question', function($q) use ($quizId) {
                $q->where('quiz_id', $quizId);
            })
            ->get();

        $totalQuestions = Question::where('quiz_id', $quizId)->count();
        $correctAnswers = $answers->where('is_correct', true)->count();

        return response()->json([
            'score' => [
                'correct' => $correctAnswers,
                'total' => $totalQuestions,
                'percentage' => round(($correctAnswers/$totalQuestions)*100, 2)
            ],
            'answers' => $answers->map(function($answer) {
                return [
                    'question_id' => $answer->question_id,
                    'choice_id' => $answer->choice_id,
                    'is_correct' => $answer->is_correct,
                    'question_text' => $answer->question->question_text,
                    'choice_text' => $answer->choice->choice_text
                ];
            })
        ]);
    }


    public function getCandidateResults($quizId)
    {
        $user = Auth::id();  
        $quiz = Quiz::findOrFail($quizId);

        $score = $this->calculateScore($quiz, $user->id);
        $passed = $score >= 32; 

        return response()->json([
            'score' => $score,
            'passed' => $passed
        ]);
    }

    
    private function calculateScore($quiz, $userId)
    {
        $questions = $quiz->questions;
        $correctAnswers = 0;

        foreach ($questions as $question) {
            $answer = $question->answers()->where('candidat_id', $userId)->first();
            if ($answer && $answer->choice->is_correct) {
                $correctAnswers++;
            }
        }

        return $correctAnswers;
    }

}