<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ChoiceController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProgressController;


use App\Http\Controllers\CandidatsController;
use App\Http\Controllers\MoniteurController;

Route::post('register', [AuthController::class, 'register']);
Route::post('connecter', [AuthController::class, 'connecter']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:api')->group(function () {


    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::post('/quizzes', [QuizController::class, 'store']);
    
    Route::post('logout', [AuthController::class, 'logout']);

    // Route::prefix('candidats')->middleware('role:candidat')->group(function () {
    //     Route::get('/dashboard', [CandidatController::class, 'dashboard'])->name('candidats.dashboard');
    // });

    // Route::prefix('moniteur')->middleware('role:moniteur')->group(function () {
    //     Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('moniteur.dashboard');
    // });

    // Route::prefix('admin')->group(function () {
    //     Route::get('/gestionCandidats', [AuthController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
    //     Route::get('/gestionMoniteur', [AuthController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');

    //         // Routes pour les quizzes
    //         Route::get('/quizzes', [QuizController::class, 'index']);
    //         Route::post('/quizzes', [QuizController::class, 'store']);
    //         Route::get('/quizzes/{id}', [QuizController::class, 'show']);
    //         Route::delete('/quizzes/{id}', [QuizController::class, 'destroy']);
            
    //         // Routes pour les questions
    //         Route::post('/quizzes/{quizId}/questions', [QuestionController::class, 'store']);
    //         Route::put('/questions/{id}', [QuestionController::class, 'update']);
    //         Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
            
    //         // Routes pour les choix
    //         Route::post('/questions/{questionId}/choices', [ChoiceController::class, 'store']);
    //         Route::put('/choices/{id}', [ChoiceController::class, 'update']);
    //         Route::delete('/choices/{id}', [ChoiceController::class, 'destroy']);
            
    //         // Routes pour les réponses
    //         Route::post('/quizzes/{quizId}/answers', [AnswerController::class, 'store']);
    //         Route::get('/quizzes/{quizId}/results', [AnswerController::class, 'getResults']);
    //         Route::get('/quizzes/{quizId}/quiz-results', [AnswerController::class, 'getQuizResults']);
   
    // });

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

Route::prefix('admin')->group(function () {
    Route::get('/titles', [TitleController::class, 'index']);       
    Route::post('/titles', [TitleController::class, 'store']);     
    Route::get('/titles/{id}', [TitleController::class, 'show']);     
    Route::put('/titles/{id}', [TitleController::class, 'update']);   
    Route::delete('/titles/{id}', [TitleController::class, 'destroy']); 

    Route::get('/courses', [CourseController::class, 'index']);    
    Route::post('/courses', [CourseController::class, 'store']);    
    Route::get('/courses/{id}', [CourseController::class, 'show']);  
    Route::put('/courses/{id}', [CourseController::class, 'update']); 
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']); 
});

Route::prefix('progress')->group(function () {
    Route::get('/{candidateId}/{courseId}', [ProgressController::class, 'show']); 
    Route::put('/{candidateId}/{courseId}', [ProgressController::class, 'update']); 
});