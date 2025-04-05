<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Answer;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'candidat';
    }

    public function view(User $user, Answer $answer): bool
    {
        return $user->id === $answer->candidat_id || $user->role === 'admin';
    }
}