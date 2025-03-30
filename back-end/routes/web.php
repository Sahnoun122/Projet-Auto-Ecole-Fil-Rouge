<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CandidatsController;
use App\Http\Controllers\MoniteurController;
use App\Http\Controllers\AuthViews;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;


Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::get('/services', 'services')->name('services');
    Route::get('/propos', 'propos')->name('propos');

});

Route::get('/register', [AuthViews::class, 'VuRegister'])->name('register');

Route::get('connecter', [AuthViews::class, 'VuConnecter'])->name('connecter');
Route::get('register', [AuthViews::class, 'VuRegister'])->name('register');






    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    });

    Route::prefix('candidats')->group(function () {
        Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');
    });

    Route::prefix('moniteur')->group(function () {
        Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('moniteur.dashboard');
    });
