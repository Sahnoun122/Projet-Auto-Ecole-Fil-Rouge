<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['admin_id', 'type_permis', 'title', 'description'];
    const PASSING_SCORE = 32;
    const TOTAL_QUESTIONS = 40;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getResults($userId)
    {
        $userAnswers = Answer::with(['choice'])
            ->where('candidat_id', $userId)
            ->whereHas('question', function($q) {
                $q->where('quiz_id', $this->id);
            })
            ->get()
            ->keyBy('question_id');
    
        $questions = $this->questions()
            ->with(['choices' => function($q) {
                $q->orderBy('is_correct', 'desc');
            }])
            ->get();
    
        $correctCount = 0;
        $wrongCount = 0;
        $results = [];
    
        foreach ($questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            $correctChoice = $question->choices->firstWhere('is_correct', true);
            $isCorrect = $userAnswer ? $userAnswer->choice->is_correct : false;
    
            if ($isCorrect) {
                $correctCount++;
            } elseif ($userAnswer) {
                $wrongCount++;
            }
    
            $results[] = [
                'question_id' => $question->id,
                'question_text' => $question->question_text,
                'user_answer' => $userAnswer ? $userAnswer->choice->choice_text : null,
                'correct_answer' => $correctChoice->choice_text ?? 'N/A',
                'is_correct' => $isCorrect,
                'answered' => (bool)$userAnswer,
                'answered_at' => $userAnswer ? $userAnswer->created_at->format('d/m/Y H:i') : null
            ];
        }
    
        $unanswered = self::TOTAL_QUESTIONS - ($correctCount + $wrongCount);
    
        return [
            'total_questions' => self::TOTAL_QUESTIONS,
            'correct_answers' => $correctCount,
            'wrong_answers' => $wrongCount,
            'unanswered' => $unanswered,
            'correct_percentage' => round(($correctCount / self::TOTAL_QUESTIONS) * 100, 2),
            'wrong_percentage' => round(($wrongCount / self::TOTAL_QUESTIONS) * 100, 2),
            'unanswered_percentage' => round(($unanswered / self::TOTAL_QUESTIONS) * 100, 2),
            'passed' => $correctCount >= self::PASSING_SCORE,
            'passing_score' => self::PASSING_SCORE,
            'details' => $results
        ];
    }
}