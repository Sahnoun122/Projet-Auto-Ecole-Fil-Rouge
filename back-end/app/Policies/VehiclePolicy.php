<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'super_admin';
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->id === $vehicle->admin_id || $user->role === 'super_admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'super_admin';
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->id === $vehicle->admin_id || $user->role === 'super_admin';
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->id === $vehicle->admin_id || $user->role === 'super_admin';
    }

    public function restore(User $user, Vehicle $vehicle): bool
    {
        return $user->role === 'super_admin';
    }

    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        return $user->role === 'super_admin';
    }

    public function manageMaintenance(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'super_admin';
    }
}