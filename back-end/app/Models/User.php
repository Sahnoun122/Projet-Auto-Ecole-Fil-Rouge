<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'Qualifications',
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

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMoniteur()
    {
        return $this->role === 'moniteur';
    }

    public function isCandidat()
    {
        return $this->role === 'candidat';
    }
}