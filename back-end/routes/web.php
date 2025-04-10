<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdmindController;
use App\Http\Controllers\CandidatsController;
use App\Http\Controllers\MoniteurController;
use App\Http\Controllers\AuthViews;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ChoiceController;
use App\Http\Controllers\API\AnswerController;

use App\Http\Controllers\API\AuthController;


Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::get('/services', 'services')->name('services');
    Route::get('/propos', 'propos')->name('propos');

});

Route::get('/register', [AuthViews::class, 'VuRegister'])->name('register');

Route::get('connecter', [AuthViews::class, 'VuConnecter'])->name('connecter');
Route::get('register', [AuthViews::class, 'VuRegister'])->name('register');

// Route::middleware('auth:api')->group(function () {

//     // // Routes Admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdmindController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/AjouterMoniteur', [AdmindController::class, 'AjouterMoniteur'])->name('admin.AjouterMoniteur');
        Route::get('/gestionCandidats', [AdmindController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
        Route::get('/gestionMoniteur', [AdmindController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');
    });


//     // Routes Candidat
    // Route::prefix('candidats')->middleware('role:candidat')->group(function () {
    //     Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');
    // });

//     // Routes Moniteur
    // Route::prefix('moniteur')->middleware('role:moniteur')->group(function () {
    //     Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('moniteur.dashboard');
    // });
// });


  Route::prefix('candidats')->group(function () {
        Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdmindController::class, 'dashboard'])->name('dashboard');
        Route::get('/AjouterMoniteur', [AdmindController::class, 'AjouterMoniteur'])->name('AjouterMoniteur');
        Route::get('/gestionCandidats', [AdmindController::class, 'gestionCandidats'])->name('gestionCandidats');
        Route::get('/gestionMoniteur', [AdmindController::class, 'gestionMoniteur'])->name('gestionMoniteur');
        Route::get('/AjouterQuiz', [AdmindController::class, 'AjouterQuiz'])->name('AjouterQuiz');
        Route::get('/AjouterQuestions/{quiz}', [AdmindController::class, 'AjouterQuestions'])->name('AjouterQuestions');

        
        // Route::get('quizzes/create', [QuizController::class, 'create'])->name('admin.quizzes.create'); // Créer un quiz
        // Route::post('quizzes', [QuizController::class, 'store'])->name('admin.quizzes.store'); // Soumettre un quiz
    
        // // Routes pour afficher et gérer les questions du quiz
        // Route::get('quizzes/{quizId}/questions', [QuestionController::class, 'index'])->name('admin.questions.index'); // Voir les questions du quiz
        // Route::get('quizzes/{quizId}/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create'); // Créer une question
        // Route::post('quizzes/{quizId}/questions', [QuestionController::class, 'store'])->name('admin.questions.store'); // Soumettre une question
        // Route::get('questions/{questionId}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit'); // Modifier une question
        // Route::put('questions/{questionId}', [QuestionController::class, 'update'])->name('admin.questions.update'); // Mettre à jour une question
        // Route::delete('questions/{questionId}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy'); // Supprimer une question
    
        // // Routes pour gérer les choix de réponse
        // Route::get('questions/{questionId}/choices/create', [ChoiceController::class, 'create'])->name('admin.choices.create'); // Créer un choix pour une question
        // Route::post('questions/{questionId}/choices', [ChoiceController::class, 'store'])->name('admin.choices.store'); // Soumettre un choix
        // Route::delete('choices/{choiceId}', [ChoiceController::class, 'destroy'])->name('admin.choices.destroy'); // Supprimer un choix
    });
    