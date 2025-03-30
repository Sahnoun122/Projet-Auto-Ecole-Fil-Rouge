<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdmindController;
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
        Route::get('/dashboard', [AdmindController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/AjouterMoniteur', [AdmindController::class, 'AjouterMoniteur'])->name('admin.AjouterMoniteur');
        Route::get('/gestionCandidats', [AdmindController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
        Route::get('/gestionMoniteur', [AdmindController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');

    });



    Route::prefix('candidats')->group(function () {
        Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');
    });

    Route::prefix('moniteur')->group(function () {
        Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('moniteur.dashboard');
    });
    