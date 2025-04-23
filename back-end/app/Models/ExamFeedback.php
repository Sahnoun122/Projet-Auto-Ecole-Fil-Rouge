<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'candidat_id',
        'exam_feedback',
        'school_comment',
        'school_rating'
    ];

    protected $casts = [
        'school_rating' => 'integer'
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