<?php

// app/Models/Quiz.php
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

    public function checkSuccess($userId)
    {
        $questions = $this->questions; 
        $correctAnswers = 0;

        foreach ($questions as $question) {
            $answer = $question->answers()->where('candidat_id', $userId)->first();
            if ($answer && $answer->choice->is_correct) {
                $correctAnswers++;
            }
        }
        return $correctAnswers >= 32;
    }
}
