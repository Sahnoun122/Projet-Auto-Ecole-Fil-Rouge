<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PresencesCours extends Pivot
{
    protected $table = 'presences_cours';

    protected $fillable = [
        'cours_conduite_id',
        'candidat_id',
        'present',
        'notes'
    ];

    public $timestamps = true;
}
