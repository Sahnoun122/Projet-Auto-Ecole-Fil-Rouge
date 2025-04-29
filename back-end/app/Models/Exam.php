<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'instructions',
        'nombre_presents',
        'taux_reussite'
    ];

    protected $casts = [
        'date_exam' => 'datetime',
    ];

    // Relations
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function examResults(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    // Méthode pour mettre à jour les statistiques
    public function updateStats(): void
    {
        $results = $this->examResults;
        
        $totalResults = $results->count();
        $presentResults = $results->where('present', true)->count();
        $successfulResults = $results->whereIn('resultat', ['excellent', 'tres_bien', 'bien'])->count();

        $this->update([
            'nombre_presents' => $presentResults,
            'taux_reussite' => $totalResults > 0 
                ? round(($successfulResults / $totalResults) * 100, 2) 
                : null
        ]);
    }

    // Méthodes de formatage
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

    // Obtenir le résultat pour un candidat spécifique
    public function getResultForCandidat(int $candidatId)
    {
        return $this->examResults()
            ->where('user_id', $candidatId)
            ->first();
    }

    // Obtenir les détails du résultat pour l'affichage
    public function getResultDetailsForDisplay(int $candidatId = null)
    {
        // Si aucun candidat n'est spécifié, utiliser le candidat assigné
        $candidatId = $candidatId ?? $this->candidat_id;

        if (!$candidatId) {
            return null;
        }

        $result = $this->getResultForCandidat($candidatId);

        if (!$result) {
            return null;
        }

        return [
            'present' => $result->present ? 'Présent' : 'Absent',
            'score' => $result->score,
            'resultat' => $result->getFormattedResultatAttribute(),
            'resultat_class' => $this->getResultatCssClass($result->resultat),
            'feedbacks' => $result->feedbacks ?? 'Aucun feedback'
        ];
    }

    private function getResultatCssClass(string $resultat): string
    {
        return match($resultat) {
            'Excellent' => 'bg-green-100 text-green-800',
            'Très bien' => 'bg-blue-100 text-blue-800',
            'Bien' => 'bg-indigo-100 text-indigo-800',
            'Moyen' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-red-100 text-red-800'
        };
    }
}