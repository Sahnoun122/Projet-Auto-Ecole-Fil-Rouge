<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'exam_id',
        'candidat_id',
        'present',
        'score',
        'resultat',
        'feedbacks'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function candidat()
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }
}