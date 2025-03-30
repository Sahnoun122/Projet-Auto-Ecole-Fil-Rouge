<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmindController;
use App\Http\Controllers\CandidatsController;
use App\Http\Controllers\MoniteurController;

Route::middleware('auth:api')->group(function () {

    // Routes Admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdmindController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/AjouterMoniteur', [AdmindController::class, 'AjouterMoniteur'])->name('admin.AjouterMoniteur');
        Route::get('/gestionCandidats', [AdmindController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
        Route::get('/gestionMoniteur', [AdmindController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');
    });

    // Routes Candidat
    Route::prefix('candidats')->middleware('role:candidat')->group(function () {
        Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');
    });

    // Routes Moniteur
    Route::prefix('moniteur')->middleware('role:moniteur')->group(function () {
        Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('moniteur.dashboard');
    });
});
