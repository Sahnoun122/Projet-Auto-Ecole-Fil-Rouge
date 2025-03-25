<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\User;

class AuthRepository implements AuthRepositoryInterface


{
    public function register( $data)
    {
        return User::create($data);
    }

    public function Connecter( $email)
    {
        return User::where('email', $email)->first();
    }

    public function modifierMotDePasse($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
    }
}