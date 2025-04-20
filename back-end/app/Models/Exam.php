<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'date_exam',
        'lieu',
        'places_max',
        'statut',
        'nombre_presents',
        'taux_reussite',
        'admin_id',
        'candidat_id',
        'instructions'
    ];

    protected $casts = [
        'date_exam' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'exam_candidat', 'exam_id', 'candidat_id')
                    ->withPivot(['present', 'resultat', 'score', 'observations', 'feedbacks'])
                    ->withTimestamps();
    }

    public function updateStats(): void
    {
        $total = $this->participants()->count();
        $presents = $this->participants()->wherePivot('present', true)->count();
        $reussis = $this->participants()->wherePivot('resultat', '!=', 'insuffisant')->count();

        $this->update([
            'nombre_presents' => $presents,
            'taux_reussite' => $total > 0 ? round(($reussis / $total) * 100, 2) : null
        ]);
    }
}