<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo_identite',
        'type_permis',
        'id_candidat'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_candidat');
    }
}