<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['admin_id', 'type_permis', 'title', 'description'];

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
        return [
            'total' => $this->questions()->count(),
            'correct' => $this->questions()
                ->whereHas('answers', function($query) use ($userId) {
                    $query->where('candidat_id', $userId)
                          ->whereHas('choice', function($q) {
                              $q->where('is_correct', true);
                          });
                })
                ->count(),
            'passed' => $this->checkSuccess($userId),
            'wrong_answers' => $this->getWrongAnswers($userId)
        ];
    }

    public function checkSuccess($userId)
    {
        $correct = $this->questions()
            ->whereHas('answers', function($query) use ($userId) {
                $query->where('candidat_id', $userId)
                      ->whereHas('choice', function($q) {
                          $q->where('is_correct', true);
                      });
            })
            ->count();
            
        return $correct >= 32;
    }

    public function getWrongAnswers($userId)
    {
        return $this->questions()
            ->with(['answers' => function($query) use ($userId) {
                $query->where('candidat_id', $userId)
                      ->with('choice');
            }])
            ->get()
            ->filter(function($question) {
                return $question->answers->isNotEmpty() && 
                       !$question->answers->first()->choice->is_correct;
            });
    }
}