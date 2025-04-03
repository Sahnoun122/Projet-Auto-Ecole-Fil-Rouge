<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; // Assurez-vous d'importer correctement
use Illuminate\Support\Facades\Gate;
use App\Models\Vehicle;
use App\Policies\VehiclePolicy;
use App\Models\Exam;
use App\Policies\ExamPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     *
     * @var array
     */
    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        Exam::class => ExamPolicy::class,
    ];

    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-exams', function ($user) {
            return $user->role === 'admin' || $user->role === 'super_admin';
        });

        Gate::define('manage-results', function ($user) {
            return $user->role === 'admin' || $user->role === 'instructor';
        });
    }
}
