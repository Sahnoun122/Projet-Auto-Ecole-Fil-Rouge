<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

     
    public function register(): void
    {

    

        // $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        // $this->app->singleton(AuthService::class, function ($app) {
        //     return new AuthService(
        //         $app->make(AuthRepositoryInterface::class)
        //     );
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
