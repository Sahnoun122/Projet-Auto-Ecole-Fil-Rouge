<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CandidatsController;
use App\Http\Controllers\MoniteurController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;

use Illuminate\Support\Facades\Route;

// Route::get('pages/accueil', function () {
//     return view('accueil');
// });

// Route::get('/', function () {
//     return view('accueil');
// });


Route::get('/', [PagesController::class, 'index'])->name('/');

Route::get('/services', [PagesController::class, 'services'])->name('services');

Route::get('/propos', [PagesController::class, 'propos'])->name('propos');

// Route::get('/register', [AuthController::class, 'register'])->name('register');


// Route::get('/connecter', [AuthController::class, 'connecter'])->name('connecter');


Route::get('/admin/dashboard' , [DashboardController::class , 'dashboard'])->name('admin.dashboard');

Route::get('/candidats/dashboard' , [CandidatsController::class , 'dashboard'])->name('candidats.dashboard');

Route::get('/moniteur/dashboard' , [MoniteurController::class , 'dashboard'])->name('moniteur.dashboard');


Route::middleware(['guest', AuthMiddleware::class])->group(function () {
    
    Route::get('/register', [AuthController::class, 'registerVue'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
});
