<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CandidatController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);

Route::post('connecter', [AuthController::class, 'connecter']);

Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});



Route::post('/register', [AuthController::class, 'register']);

Route::get('/candidats', [AuthController::class, 'getCandidats']);
Route::get('/candidats/search', [AuthController::class, 'searchCandidats']);
Route::delete('/candidats/{id}', [AuthController::class, 'deleteCandidat']);

Route::get('/moniteurs', [AuthController::class, 'getMoniteurs']);
Route::get('/moniteurs/search', [AuthController::class, 'searchMoniteurs']);
Route::delete('/moniteurs/{id}', [AuthController::class, 'deleteMoniteur']);
    