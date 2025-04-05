<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Choice;
use Illuminate\Auth\Access\Response;

class ChoicePolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Choice $choice): bool
    {
        return $user->role === 'admin' && $choice->admin_id === $user->id;
    }

    public function delete(User $user, Choice $choice): bool
    {
        return $user->role === 'admin' && $choice->admin_id === $user->id;
    }
}
