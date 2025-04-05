<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Progress;

class ProgressPolicy
{
    public function view(User $user, Progress $progress): bool
    {
        return $user->id === $progress->candidate_id || $user->role === 'admin';
    }

    public function update(User $user, Progress $progress): bool
    {
        return $user->id === $progress->candidate_id;
    }
}