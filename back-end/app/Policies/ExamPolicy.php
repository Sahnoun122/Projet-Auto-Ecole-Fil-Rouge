<?php
namespace App\Policies;

use App\Models\Exam;
use App\Models\User;

class ExamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Exam $exam): bool
    {
        return $user->id === $exam->admin_id || $user->role === 'super_admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Exam $exam): bool
    {
        return $user->id === $exam->admin_id || $user->role === 'super_admin';
    }

    public function delete(User $user, Exam $exam): bool
    {
        return $user->id === $exam->admin_id || $user->role === 'super_admin';
    }

    public function manageResults(User $user): bool
    {
        return $user->role === 'admin';
    }
}