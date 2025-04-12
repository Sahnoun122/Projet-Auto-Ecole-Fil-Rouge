<?php

// namespace App\Http\Controllers;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdmindController;
use App\Http\Controllers\CandidatsController;
use App\Http\Controllers\MoniteurController;
use App\Http\Controllers\AuthViews;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\QuizPlayController;
use App\Http\Controllers\API\AuthController;

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::get('/services', 'services')->name('services');
    Route::get('/propos', 'propos')->name('propos');
});

Route::get('/register', [AuthViews::class, 'VuRegister'])->name('register');
Route::get('connecter', [AuthViews::class, 'VuConnecter'])->name('connecter');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdmindController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/AjouterMoniteur', [AdmindController::class, 'AjouterMoniteur'])->name('admin.AjouterMoniteur');
    Route::get('/gestionCandidats', [AdmindController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
    Route::get('/gestionMoniteur', [AdmindController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');
});

Route::prefix('candidats')->group(function () {
    Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');
});

Route::prefix('admin')->group(function () {
    Route::get('/AjouterQuiz', [QuizController::class, 'index'])->name('admin.AjouterQuiz');
    Route::post('/AjouterQuiz', [QuizController::class, 'store'])->name('admin.AjouterQuiz.store');
    Route::put('/AjouterQuiz/{quiz}', [QuizController::class, 'update'])->name('admin.AjouterQuiz.update');
    Route::delete('/AjouterQuiz/{quiz}', [QuizController::class, 'destroy'])->name('admin.AjouterQuiz.destroy');

        Route::get('/{quiz}/questions', [QuestionController::class, 'index'])->name('admin.questions');
        Route::post('/quiz/{quiz}/questions', [QuestionController::class, 'store'])->name('admin.quiz.questions');
        Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('admin.questions');
        Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('admin.questions');
        Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('admin.questions');
        Route::get('/questions/{question}/details', [QuestionController::class, 'details'])->name('admin.questions');

        
    Route::post('/questions/{question}/choices', [ChoiceController::class, 'store'])->name('admin.choices.store');
    Route::put('/choices/{choice}', [ChoiceController::class, 'update'])->name('admin.choices.update');
    Route::delete('/choices/{choice}', [ChoiceController::class, 'destroy'])->name('admin.choices.destroy');
});

Route::get('/quiz/{quiz}/play', [QuizPlayController::class, 'show'])->name('quiz.play');
Route::post('/quiz/{quiz}/submit', [AnswerController::class, 'store'])->name('quiz.submit');
Route::get('/quiz/{quiz}/results', [AnswerController::class, 'getResults'])->name('quiz.results');
