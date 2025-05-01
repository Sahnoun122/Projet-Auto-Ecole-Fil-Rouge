<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'date_exam',
        'lieu',
        'places_max',
        'statut',
        'candidat_id',
        'admin_id',
        'instructions'
    ];

    protected $casts = [
        'date_exam' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function candidat()
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function result()
    {
        return $this->hasOne(ExamResult::class);
    }

    public function getFormattedTypeAttribute(): string
    {
        return match($this->type) {
            'theorique' => 'Théorique',
            'pratique' => 'Pratique',
            default => $this->type
        };
    }

    public function getFormattedStatutAttribute(): string
    {
        return match($this->statut) {
            'planifie' => 'Planifié',
            'en_cours' => 'En cours',
            'termine' => 'Terminé',
            'annule' => 'Annulé',
            default => $this->statut
        };
    }

    public function getStatutCssClassAttribute(): string
    {
        return match($this->statut) {
            'planifie' => 'bg-yellow-100 text-yellow-800',
            'en_cours' => 'bg-blue-100 text-blue-800',
            'termine' => 'bg-green-100 text-green-800',
            'annule' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}