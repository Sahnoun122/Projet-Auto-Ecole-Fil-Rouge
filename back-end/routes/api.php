<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\MoniteurController;

Route::post('register', [AuthController::class, 'register']);
Route::post('connecter', [AuthController::class, 'connecter']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    // Route::prefix('candidats')->middleware('role:candidat')->group(function () {
    //     Route::get('/dashboard', [CandidatController::class, 'dashboard'])->name('candidats.dashboard');
    // });

    // Route::prefix('moniteur')->middleware('role:moniteur')->group(function () {
    //     Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('moniteur.dashboard');
    // });

    // Route::prefix('admin')->middleware('role:admin')->group(function () {
    //     Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    //     Route::get('/gestionCandidats', [AuthController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
    //     Route::get('/gestionMoniteur', [AuthController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');
    // });


});
Route::get('/gestionCandidats', [AuthController::class, 'getCandidats'])->name('admin.gestionCandidats');


Route::get('/getMoniteurs', [AuthController::class, 'getMoniteurs'])->name('admin.gestionMoniteur');

Route::put('ModifierMoniteur/{id}', [AuthController::class, 'updateUser'])->name('admin.gestionMoniteur');
