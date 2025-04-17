<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoursConduite extends Model
{
    use SoftDeletes;

    protected $table = 'cours_conduites';

    protected $fillable = [
        'date_heure',
        'duree_minutes',
        'statut',
        'moniteur_id',
        'vehicule_id',
        'admin_id'
    ];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    public function moniteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moniteur_id');
    }

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function candidats(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'presences_cours', 'cours_conduite_id', 'candidat_id')
                    ->withPivot(['present', 'notes'])
                    ->withTimestamps();
    }
}
