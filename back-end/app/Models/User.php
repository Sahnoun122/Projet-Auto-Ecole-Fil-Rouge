<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'adresse',
        'telephone',
        'photo_profile',
        'photo_identite',
        'type_permis',
        'certifications',
        'qualifications',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfilePhotoUrlAttribute()
    {
        return $this->photo_profile 
            ? asset('storage/'.$this->photo_profile)
            : asset('images/default-profile.png');
    }


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMoniteur(): bool
    {
        return $this->role === 'moniteur';
    }

    public function isCandidat(): bool
    {
        return $this->role === 'candidat';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_candidat')
                    ->withPivot(['present', 'resultat', 'score', 'observations', 'feedbacks'])
                    ->withTimestamps();
    }

public function coursCommeMoniteur()
{
    return $this->hasMany(CoursConduite::class, 'moniteur_id');
}

public function coursCommeCandidat()
{
    return $this->hasMany(CoursConduite::class, 'candidat_id');
}

public function coursSupplementaires()
{
    return $this->belongsToMany(
        CoursConduite::class, 
        'presences_cours', 
        'candidat_id', 
        'cours_conduite_id'
    );
}
    /**
     * Retourne l'identifiant unique de l'utilisateur pour le JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Habituellement, l'ID de l'utilisateur
    }

    /**
     * Retourne les réclamations personnalisées du JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
