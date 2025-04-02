<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ChoiceController;
use App\Http\Controllers\API\AnswerController;


use App\Http\Controllers\CandidatsController;
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

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/gestionCandidats', [AuthController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
        Route::get('/gestionMoniteur', [AuthController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');

        Route::resource('quizzes', QuizController::class); 
        Route::resource('questions', QuestionController::class); 
    
        Route::resource('choices', ChoiceController::class);
    
        Route::get('results/{quizId}', [AnswerController::class, 'getResults']); 
    });


});


// Route::middleware('auth:api')->prefix('admin')->group(function () {
//     Route::resource('quizzes', QuizController::class);
//     Route::resource('questions', QuestionController::class);
//     Route::resource('choices', ChoiceController::class);
//     Route::get('results', [AnswerController::class, 'getResults']);
// });

// Route::middleware('auth:api')->prefix('candidate')->group(function () {
//     Route::get('quizzes', [QuizController::class, 'index']);
//     Route::get('quizzes/{quizId}', [QuizController::class, 'show']);
//     Route::post('quizzes/{quizId}/submit', [AnswerController::class, 'store']);
//     Route::get('results', [AnswerController::class, 'getCandidateResults']);
// });

Route::get('/gestionCandidats', [AuthController::class, 'getCandidats'])->name('admin.gestionCandidats');


Route::get('/getMoniteurs', [AuthController::class, 'getMoniteurs'])->name('admin.gestionMoniteur');

Route::put('ModifierMoniteur/{id}', [AuthController::class, 'updateUser'])->name('admin.gestionMoniteur');
