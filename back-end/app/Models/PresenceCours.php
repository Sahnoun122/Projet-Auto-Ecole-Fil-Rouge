<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceCours extends Model
{
    use HasFactory;
    
    protected $table = 'presences_cours';
    
    protected $fillable = [
        'cours_conduite_id',
        'candidat_id',
        'present',
        'notes'
    ];
    
    protected $casts = [
        'present' => 'boolean',
    ];
    
    public function cours()
    {
        return $this->belongsTo(CoursConduite::class, 'cours_conduite_id');
    }
    
    public function candidat()
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }
}
