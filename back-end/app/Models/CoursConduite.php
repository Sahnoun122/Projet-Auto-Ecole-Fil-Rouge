<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoursConduite extends Model
{
    protected $fillable = [
        'date_heure', 
        'duree_minutes',
        'statut',
        'moniteur_id', 
        'vehicule_id',
        'admin_id',
        'candidat_id'

    ];

    // Relation avec le moniteur (User)
    public function moniteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moniteur_id');
    }

    // Relation avec le véhicule
    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicule_id');
    }

    // Relation avec le candidat principal (User)
    public function candidat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    // Relation Many-to-Many avec les candidats supplémentaires
    public function candidats(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class, 
            'presences_cours',  // Nom de la table pivot
            'cours_conduite_id', 
            'candidat_id'
        )->withPivot(['present', 'notes']);
    }
}