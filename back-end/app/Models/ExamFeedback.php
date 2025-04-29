<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamFeedback extends Model
{
    use HasFactory;

    protected $table = 'exam_feedbacks';

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

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function getRatingLabelAttribute(): string
    {
        return match($this->school_rating) {
            1 => 'Très insatisfait',
            2 => 'Insatisfait',
            3 => 'Neutre',
            4 => 'Satisfait',
            5 => 'Très satisfait',
            default => 'Non noté'
        };
    }
}