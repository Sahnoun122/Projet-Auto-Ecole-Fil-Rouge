<?php

// namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Paiement;
use Illuminate\Notifications\Notifiable; 
use Illuminate\Support\Facades\Auth; 
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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\CoursConduiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExamFeedbackController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\PaiementController
;

use App\Http\Controllers\PresenceCoursController;

use App\Http\Controllers\NotificationController;





Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::get('/services', 'services')->name('services');
    Route::get('/propos', 'propos')->name('propos');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');



Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {


    Route::get('/monitors', [MoniteurController::class, 'index'])->name('admin.monitors.index');
    Route::post('/monitors', [MoniteurController::class, 'store'])->name('admin.monitors.store');
    Route::get('/monitors/{moniteur}/edit', [MoniteurController::class, 'edit'])->name('admin.monitors.edit');
    Route::put('/monitors/{monitor}', [MoniteurController::class, 'update'])->name('admin.monitors.update');
    Route::delete('/monitors/{monitor}', [MoniteurController::class, 'destroy'])->name('admin.monitors.destroy');
    Route::get('/monitors/{id}', [MoniteurController::class, 'show'])->name('admin.monitors.show');


    Route::get('/candidats', [CandidatsController::class, 'index'])->name('admin.candidats');
    Route::get('/candidats/create', [CandidatsController::class, 'create'])->name('admin.candidats.create');
    Route::post('/candidats/store', [CandidatsController::class, 'store'])->name('admin.candidats.store');
    Route::get('/candidats/{id}/edit', [CandidatsController::class, 'edit'])->name('admin.candidats.edit');
    Route::put('/candidats/update/{id}', [CandidatsController::class, 'update'])->name('admin.candidats.update');
    Route::delete('/candidats/destroy/{id}', [CandidatsController::class, 'destroy'])->name('admin.candidats.destroy');
    Route::get('/candidats/{id}', [CandidatsController::class, 'show'])->name('admin.candidats.show');

    Route::get('/dashboard', [AdmindController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/gestionCandidats', [AdmindController::class, 'gestionCandidats'])->name('admin.gestionCandidats');
    Route::get('/gestionMoniteur', [AdmindController::class, 'gestionMoniteur'])->name('admin.gestionMoniteur');

    
        Route::get('/quizzes', [QuizController::class, 'index'])->name('admin.quizzes');
        Route::post('/quizzes', [QuizController::class, 'store'])->name('admin.quizzes.store');
        Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('admin.quizzes.update');
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('admin.quizzes.destroy');

        Route::get('/{quiz}/results', [QuizController::class, 'results'])->name('admin.results');
        Route::get('/{quiz}/results/{candidate}', [QuizController::class, 'candidateResults'])->name('admin.candidate-results');
   
            Route::get('/{quiz}/questions', [QuestionController::class, 'index'])
                 ->name('admin.questions.index');

                        Route::post('/{quiz}/questions', [QuestionController::class, 'store'])
                 ->name('admin.questions.store');

                        Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])
                 ->name('admin.questions.edit');
                 
                        Route::put('/questions/{question}', [QuestionController::class, 'update'])
                 ->name('admin.questions.update');
            
            Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])
                 ->name('admin.questions.destroy');
            
            Route::get('/questions/{question}/details', [QuestionController::class, 'showDetails'])
                 ->name('admin.questions.details');
        
    Route::post('/questions/{question}/choices', [ChoiceController::class, 'store'])->name('admin.choices.store');
    Route::put('/choices/{choice}', [ChoiceController::class, 'update'])->name('admin.choices.update');
    Route::delete('/choices/{choice}', [ChoiceController::class, 'destroy'])->name('admin.choices.destroy');

        Route::get('/titles', [TitleController::class, 'index'])->name('admin.titles');
        Route::post('/titles', [TitleController::class, 'store'])->name('admin.titles.store');
        Route::put('/titles/{title}', [TitleController::class, 'update'])->name('admin.titles.update');
        Route::delete('/titles/{title}', [TitleController::class, 'destroy'])->name('admin.titles.destroy');
  
        Route::get('titles/{title}/progress', [TitleController::class, 'progress'])
        ->name('admin.progress');
    
    Route::get('titles/{title}/candidate/{candidate}/progress', [TitleController::class, 'candidateProgress'])
        ->name('admin.candidate-progress');
        
        Route::get('/titles/{title}/courses', [CourseController::class, 'index'])->name('admin.courses');
        Route::post('/titles/{title}/courses', [CourseController::class, 'store'])->name('admin.courses.store');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');
        Route::get('/{title}/progress', [TitleController::class, 'progress'])->name('admin.progress');


    Route::get('/vehicles', [VehicleController::class, 'index'])
         ->name('admin.vehicles');
    
    Route::post('/vehicles', [VehicleController::class, 'store'])
         ->name('admin.vehicles.store');
    
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
         ->name('admin.vehicles.update');
    
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])
         ->name('admin.vehicles.destroy');
    
    Route::get('/vehicles/maintenance-alerts', [VehicleController::class, 'maintenanceAlerts'])
         ->name('admin.vehicles.maintenance-alerts');

         Route::get('/reporting', [ReportingController::class, 'index'])->name('admin.reporting');
         Route::get('/reporting/data', [ReportingController::class, 'getReportData'])->name('admin.reporting.data');
         Route::post('/reporting/generate-pdf', [ReportingController::class, 'generatePdfReport'])->name('admin.reporting.generate-pdf');


    
               
    Route::get('/conduite', [CoursConduiteController::class, 'index'])->name('admin.conduite');
    Route::post('/conduite', [CoursConduiteController::class, 'store'])->name('admin.conduite.store');
    Route::put('/conduite/{coursConduite}', [CoursConduiteController::class, 'update'])->name('admin.conduite.update');
    Route::delete('/conduite/{coursConduite}', [CoursConduiteController::class, 'destroy'])->name('admin.conduite.destroy');
    Route::get('/conduite/{id}/presences', [CoursConduiteController::class, 'getPresences'])
         ->name('admin.conduite.presences');

    Route::get('/exams', [ExamController::class, 'index'])->name('admin.exams');
    Route::post('/exams', [ExamController::class, 'store'])->name('admin.exams.store');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('admin.exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('admin.exams.destroy');

    Route::post('/exams/{exam}/results', [ExamController::class, 'storeResult'])->name('admin.exams.results.store');
    Route::put('/exams/{exam}/results/{candidat}', [ExamController::class, 'updateResult'])->name('admin.exams.results.update');
    
    Route::get('/exams/{exam}/candidat/{candidat}/result', [ExamController::class, 'checkResult'])->name('admin.exams.results.check');


    Route::get('/paiements', [PaiementController::class, 'index'])->name('admin.paiements');
    Route::get('/paiements/create', [PaiementController::class, 'create'])->name('admin.paiements.create');
    Route::post('/paiements', [PaiementController::class, 'store'])->name('admin.paiements.store');
    Route::get('/paiements/{paiement}/edit', [PaiementController::class, 'edit'])->name('admin.paiements.edit');
    Route::put('/paiements/{paiement}', [PaiementController::class, 'update'])->name('admin.paiements.update');
    Route::delete('/paiements/{paiement}', [PaiementController::class, 'destroy'])->name('admin.paiements.destroy');
    Route::get('/paiements/{paiement}/details', [PaiementController::class, 'show'])->name('admin.paiements.show');


});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', function() {
//     return redirect()->route('exams.index');
// });

            

Route::get('/email/unsubscribe/{user}/{token}', [NotificationController::class, 'unsubscribe'])
    ->name('email.unsubscribe');

Route::post('/notifications/{notification}/mark-as-read', function ($notificationId) {
   /** @var \App\Models\User  */
   $user = Auth::user();    
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
    }

    $affected = $user->unreadNotifications()
                    ->where('id', $notificationId)
                    ->update(['read_at' => now()]);

    return response()->json([
        'success' => (bool)$affected,
        'message' => $affected ? 'Notification marquée comme lue' : 'Notification non trouvée'
    ]);
})->middleware('auth')->name('notifications.markAsRead');

Route::get('/notifications', function () {
   /** @var \App\Models\User $user */
   $user = Auth::user();    
    return view('notifications', [
        'notifications' => $user->notifications()->paginate(10)
    ]);
})->middleware('auth')->name('notifications');




Route::prefix('candidats')->middleware(['auth', 'role:candidat'])->group(function () {
    Route::get('/dashboard', [CandidatsController::class, 'dashboard'])->name('candidats.dashboard');

        Route::get('/quizzes', [QuizController::class, 'indexForCandidat'])
            ->name('candidats.quizzes');
            
        Route::get('/{quiz}/prepare', [QuizController::class, 'prepareQuiz'])

            ->name('candidats.prepare');
            
        Route::get('/{quiz}/start', [QuizController::class, 'startQuiz'])

            ->name('candidats.start');
            
        Route::get('/{quiz}/questions/{question}', [QuizController::class, 'showQuestion'])

            ->name('candidats.questions');
            
        // Route::post('/{quiz}/questions/{question}/answer', [QuizController::class, 'submitAnswer'])
        //     ->name('candidats.questions');

            Route::post('/{quiz}/questions/{question}', [QuizController::class, 'submitAnswer'])

     ->name('candidats.questions');
            
        Route::get('/{quiz}/results', [QuizController::class, 'showResults'])

            ->name('candidats.results');
// Route::get('/titres', [TitleController::class, 'indexForCandidat'])->name('candidats.titres');

// Route::get('/titres/{title}', [TitleController::class, 'showForCandidat'])->name('candidats.titres');

// Route::get('/{title}/cours', [CourseController::class, 'showCourses'])
//      ->name('candidats.cours');

Route::get('/titres', [TitleController::class, 'indexForCandidat'])->name('candidats.titres');
    
Route::get('/cours/{title}', [CourseController::class, 'showCourses'])->name('candidats.cours');

Route::get('/cours/{course}/detail', [CourseController::class, 'showCourseDetail'])->name('candidats.cours.detail');


     Route::get('/conduite', [CoursConduiteController::class, 'candidatIndex'])->name('candidats.conduite');
     Route::get('/conduite/{courseId}/show', [CoursConduiteController::class, 'candidatShow'])->name('candidats.conduite.show');
     
     
    Route::get('/exams', [ExamController::class, 'candidatExams'])->name('candidats.exams');
    Route::get('/exams/{exam}', [ExamController::class, 'showCandidatExam'])->name('candidats.exams.show');

    Route::prefix('exams')->group(function () {
        Route::get('/', [ExamController::class, 'candidatExams'])->name('candidats.exams');
        
        Route::prefix('{exam}/feedback')->group(function () {
            Route::get('/', [ExamFeedbackController::class, 'index'])->name('candidats.exams.feedback');
            Route::post('/', [ExamFeedbackController::class, 'store'])->name('candidats.exams.feedback.store');
            Route::delete('/', [ExamFeedbackController::class, 'destroy'])->name('candidats.exams.feedback.destroy');
        });


    });

        Route::get('/mes-paiements', [PaiementController::class, 'candidatIndex'])->name('candidats.paiements');
        Route::get('/mes-paiements/{paiement}/details', function(Paiement $paiement) {
            if ($paiement->user_id !== Auth::id()) {
                abort(403);
            }
            return view('candidats.paiements.details', compact('paiement'));
        });


    });

Route::prefix('moniteur')->middleware(['auth', 'role:moniteur'])->name('moniteur.')->group(function() {
    // Correct the route name to just 'dashboard'
    Route::get('/dashboard', [MoniteurController::class, 'dashboard'])->name('dashboard');

        // Standardize route names within the group (remove explicit 'moniteur.' prefix)
        Route::get('/conduite', [PresenceCoursController::class, 'index'])->name('conduite');
        Route::post('/conduite/{courseId}/presences', [PresenceCoursController::class, 'updatePresences'])->name('conduite.presences');

         Route::get('/vehicles', [VehicleController::class, 'indexMoniteur'])->name('vehicles');

         Route::get('/candidats', [MoniteurController::class, 'candidats'])->name('candidats'); // Already correct
         Route::get('/candidats/{candidat}/progression', [MoniteurController::class, 'progression'])->name('progression');
         Route::get('/candidats/{candidat}/cours', [MoniteurController::class, 'cours'])->name('cours');
         Route::get('/candidats/{candidat}/quiz', [MoniteurController::class, 'quiz'])->name('quiz');

         Route::get('/quiz/{quiz}/candidat/{candidat}/results', [MoniteurController::class, 'quizResults'])->name('quiz.results');

         // Corrected route to use showAssignedExams
         Route::get('/exams', [MoniteurController::class, 'showAssignedExams'])->name('exams'); 
         
         // Remove or comment out the route for storing results
         // Route::post('/exams/{exam}/results', [MoniteurController::class, 'storeExamResults'])->name('exams.results.store');

         // Keep the route for viewing individual candidate results if needed, or adjust as necessary
         Route::get('/exams/{candidat}/results', [MoniteurController::class, 'candidatExamResults'])->name('results');



});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
