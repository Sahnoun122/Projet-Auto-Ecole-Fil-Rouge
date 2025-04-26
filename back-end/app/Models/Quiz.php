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
        $totalQuestions = $this->questions()->count();
        $passingScore = self::PASSING_SCORE;

        $userAnswers = Answer::with(['choice', 'question'])
            ->where('candidat_id', $userId)
            ->whereHas('question', function($q) {
                $q->where('quiz_id', $this->id);
            })
            ->get()
            ->keyBy('question.id');

        $correctCount = 0;
        $wrongCount = 0;
        $results = [];

        foreach ($this->questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
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
                'correct_answer' => $question->correctChoice->choice_text ?? 'N/A',
                'is_correct' => $isCorrect,
                'answered' => (bool)$userAnswer,
                'answered_at' => $userAnswer ? $userAnswer->created_at->format('d/m/Y H:i') : null
            ];
        }

        $unanswered = $totalQuestions - ($correctCount + $wrongCount);

        return [
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctCount,
            'wrong_answers' => $wrongCount,
            'unanswered' => $unanswered,
            'correct_percentage' => round(($correctCount / $totalQuestions) * 100, 2),
            'wrong_percentage' => round(($wrongCount / $totalQuestions) * 100, 2),
            'unanswered_percentage' => round(($unanswered / $totalQuestions) * 100, 2),
            'passed' => $correctCount >= $passingScore,
            'passing_score' => $passingScore,
            'details' => $results
        ];
    }
}