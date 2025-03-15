<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

// Route::get('pages/accueil', function () {
//     return view('accueil');
// });

// Route::get('/', function () {
//     return view('accueil');
// });


Route::get('/accueil', [PagesController::class, 'accueil'])->name('accueil');

Route::get('/services', [PagesController::class, 'services'])->name('services');




