<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'present',
        'score',
        'resultat',
        'feedbacks'
    ];

    protected $casts = [
        'present' => 'boolean',
        'date_enregistrement' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function getFormattedResultatAttribute(): string
    {
        return match($this->resultat) {
            'excellent' => 'Excellent',
            'tres_bien' => 'Très bien',
            'bien' => 'Bien',
            'moyen' => 'Moyen',
            'insuffisant' => 'Insuffisant',
            default => $this->resultat
        };
    }

    public function getPresentStatusAttribute(): string
    {
        return $this->present ? 'Présent' : 'Absent';
    }
}