<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CoursConduite;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursConduitePolicy
{
    use HandlesAuthorization;

    /**
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('moniteur');
    }

    /**
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoursConduite  $coursConduite
     * @return bool
     */
    public function view(User $user, CoursConduite $coursConduite)
    {
        return $user->id === $coursConduite->admin_id || $user->hasRole('moniteur');
    }

    /**
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('moniteur');
    }

    /**
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoursConduite  $coursConduite
     * @return bool
     */
    public function update(User $user, CoursConduite $coursConduite)
    {
        return $user->id === $coursConduite->admin_id || $user->id === $coursConduite->moniteur_id;
    }

    /**
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoursConduite  $coursConduite
     * @return bool
     */
    public function delete(User $user, CoursConduite $coursConduite)
    {
        return $user->id === $coursConduite->admin_id;
    }

    /**
     *
     * @param  \App\Models\User  
     * @param  \App\Models\CoursConduite  
     * @return bool
     */
    public function manageAttendance(User $user, CoursConduite $coursConduite)
    {
        return $user->id === $coursConduite->moniteur_id || $user->id === $coursConduite->admin_id;
    }
}
