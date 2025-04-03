<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    protected $fillable = ['type', 'date_exam', 'lieu', 'places_max', 'admin_id'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function candidats(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'exam_candidat')
                   ->withPivot('resultat', 'observations')
                   ->withTimestamps();
    }
}
