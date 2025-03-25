<?php
namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function register ( $data);
    public function Connecter( $email);
    public function modifierMotDePasse($user,$password);
}