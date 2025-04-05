<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Question $question): bool
    {
        return $user->role === 'admin' && $question->admin_id === $user->id;
    }

    public function delete(User $user, Question $question): bool
    {
        return $user->role === 'admin' && $question->admin_id === $user->id;
    }
}
