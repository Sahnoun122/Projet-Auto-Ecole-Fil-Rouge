<?php

use App\Http\Controllers\PagesController;
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




