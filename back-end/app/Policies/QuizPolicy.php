<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quiz;
use Illuminate\Auth\Access\Response;

class QuizPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Quiz $quiz): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Quiz $quiz): bool
    {
        return $user->role === 'admin' && $quiz->admin_id === $user->id;
    }

    public function delete(User $user, Quiz $quiz): bool
    {
        return $user->role === 'admin' && $quiz->admin_id === $user->id;
    }
}
