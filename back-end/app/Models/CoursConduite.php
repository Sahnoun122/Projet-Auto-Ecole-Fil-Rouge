<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursConduite extends Model
{
    use HasFactory;
    
    protected $table = 'cours_conduites';
    
    protected $fillable = [
        'date_heure',
        'duree_minutes',
        'moniteur_id',
        'vehicule_id',
        'admin_id',
        'statut'
    ];
    
    protected $casts = [
        'date_heure' => 'datetime',
    ];
    
    public function moniteur()
    {
        return $this->belongsTo(User::class, 'moniteur_id');
    }
    
    public function vehicule()
    {
        return $this->belongsTo(Vehicle::class, 'vehicule_id');
    }
    
    public function presences()
    {
        return $this->hasMany(PresenceCours::class, 'cours_conduite_id');
    }
    
    public function candidats()
    {
        return $this->belongsToMany(User::class, 'presences_cours', 'cours_conduite_id', 'candidat_id')
                    ->withPivot('present', 'notes')
                    ->withTimestamps();
    }
}