<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CandidatsController;

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

Route::get('/register', [PagesController::class, 'register'])->name('register');


Route::get('/connecter', [PagesController::class, 'connecter'])->name('connecter');

Route::get('/admin/dashboard' , [DashboardController::class , 'dashboard'])->name('admin.dashboard');

Route::get('/candidats/dashboard' , [CandidatsController::class , 'dashboard'])->name('candidats.dashboard');

