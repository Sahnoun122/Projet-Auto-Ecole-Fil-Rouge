<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exam;
use Illuminate\Auth\Access\Response;

class ExamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'moniteur']);
    }

    public function view(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin') || 
               $user->id === $exam->moniteur_id ||
               $exam->candidats->contains($user->id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin') || $user->id === $exam->moniteur_id;
    }

    public function delete(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin');
    }

    public function manageCandidats(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin') || $user->id === $exam->moniteur_id;
    }

    public function recordResults(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin') || $user->id === $exam->moniteur_id;
    }
}