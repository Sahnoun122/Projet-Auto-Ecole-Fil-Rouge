<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceCours extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_conduite_id',
        'candidat_id',
        'present',
        'notes'
    ];

    public function cours()
    {
        return $this->belongsTo(CoursConduite::class);
    }

    public function candidat()
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }
}