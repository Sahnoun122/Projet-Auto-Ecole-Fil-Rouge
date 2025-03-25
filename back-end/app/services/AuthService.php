<?php 

// app/Services/AuthService.php
namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;  
use App\Models\User;
class AuthService
{
    protected $AuthRepository;

    public function __construct(AuthRepositoryInterface $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

    public function register( $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->AuthRepository->register($data);
    }

    public function login( $credentials)
    {
        $user = $this->AuthRepository->Connecter($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function modifierMotDePasse(User $user, $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $user->save();
    }

    
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();
    }

    public function refreshToken()
    {
        return JWTAuth::parseToken()->refresh();
    }
}

