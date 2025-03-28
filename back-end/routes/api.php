<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CandidatController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::post('/complete-registration', [CandidatController::class, 'completeRegistration']);
Route::get('/candidat-info', [CandidatController::class, 'getCandidatInfo']);
