<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Title;
use Illuminate\Auth\Access\Response;

class TitlePolicy
{
    public function viewAny(User $user): bool
    {
        return true; 
    }

    public function view(User $user, Title $title): bool
    {
        return $user->role === 'admin' || $title->type_permis === $user->type_permis;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Title $title): bool
    {
        return $user->role === 'admin' && $title->admin_id === $user->id;
    }

    public function delete(User $user, Title $title): bool
    {
        return $user->role === 'admin' && $title->admin_id === $user->id;
    }
}