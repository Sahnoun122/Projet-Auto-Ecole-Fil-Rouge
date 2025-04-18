<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'marque', 'modele', 'immatriculation', 'date_achat',
        'kilometrage', 'prochaine_maintenance', 'statut', 'admin_id'
    ];

    protected $casts = [
        'date_achat' => 'date',
        'prochaine_maintenance' => 'date'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function coursConduites()
{
    return $this->hasMany(CoursConduite::class, 'vehicule_id');
}
}