<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return true; 
    }

    public function view(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->title->type_permis === $user->type_permis;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Course $course): bool
    {
        return $user->role === 'admin' && $course->admin_id === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'admin' && $course->admin_id === $user->id;
    }
}