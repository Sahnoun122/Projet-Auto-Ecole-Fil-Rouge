<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

protected $fillable = ['quiz_id', 'admin_id', 'question_text', 'image_path', 'duration'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // public function correctChoice()
    // {
    //     return $this->hasOne(Choice::class)->where('is_correct', true);
    // }

}

