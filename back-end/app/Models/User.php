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
