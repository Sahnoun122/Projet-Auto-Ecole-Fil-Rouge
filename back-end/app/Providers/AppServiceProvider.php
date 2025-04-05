<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; // Assurez-vous d'importer correctement
use Illuminate\Support\Facades\Gate;
use App\Models\Vehicle;
use App\Policies\VehiclePolicy;
use App\Models\Exam;
use App\Policies\ExamPolicy;
use App\Models\CoursConduite;

use App\Policies\TitlePolicy;
use App\Models\Title;

use App\Policies\CoursePolicy;
use App\Models\Course;

use App\Policies\CoursConduitePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     *
     * @var array
     */
    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        Exam::class => ExamPolicy::class,
        CoursConduite::class => CoursConduitePolicy::class,
        Title::class => TitlePolicy::class,
        Course::class => CoursePolicy::class,
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


        Gate::define('viewAny', [TitlePolicy::class, 'viewAny']);
        Gate::define('view', [TitlePolicy::class, 'view']);

        Gate::define('viewAny', [CoursePolicy::class, 'viewAny']);
        Gate::define('view', [CoursePolicy::class, 'view']);
        Gate::define('create', [CoursePolicy::class, 'create']);
        Gate::define('update', [CoursePolicy::class, 'update']);
        Gate::define('delete', [CoursePolicy::class, 'delete']);
    }
}
