<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; // Assurez-vous d'importer correctement
use Illuminate\Support\Facades\Gate;
use App\Models\Vehicle;
use App\Policies\VehiclePolicy;
use App\Models\Exam;
use App\Policies\ExamPolicy;
use App\Models\CoursConduite;

use App\Policies\TitlePolicy;
use App\Models\Title;

use App\Policies\CoursePolicy;
use App\Models\Course;

use App\Policies\ProgressPolicy;
use App\Models\Progress;

use App\Policies\QuizPolicy;
use App\Models\Quiz;

use App\Policies\QuestionPolicy;
use App\Models\Question;

use App\Policies\ChoicePolicy;
use App\Models\Choice;

use App\Policies\AnswerPolicy;
use App\Models\Answer;

use App\Policies\CoursConduitePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /** 
     *
     * @var array
     */
    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        Exam::class => ExamPolicy::class,
        CoursConduite::class => CoursConduitePolicy::class,
        Title::class => TitlePolicy::class,
        Course::class => CoursePolicy::class,
        Progress::class => ProgressPolicy::class,
        Quiz::class => QuizPolicy::class,
        Question::class => QuestionPolicy::class,
        Choice::class => ChoicePolicy::class,
        Answer::class => AnswerPolicy::class,
    
    ]; 

    /**
     *
     * @return void
     */
    public function boot()
    {
      
            $this->registerPolicies();
        
            Gate::define('manage-exams', function ($user) {
                return $user->role === 'admin' || $user->role === 'super_admin';
            });
        
            Gate::define('manage-results', function ($user) {
                return $user->role === 'admin' || $user->role === 'instructor';
            });
        
            // Définition des gates pour le modèle Title
            Gate::define('viewAny-title', [TitlePolicy::class, 'viewAny']);
            Gate::define('view-title', [TitlePolicy::class, 'view']);
        
            // Définition des gates pour le modèle Course
            Gate::define('viewAny-course', [CoursePolicy::class, 'viewAny']);
            Gate::define('view-course', [CoursePolicy::class, 'view']);
            Gate::define('create-course', [CoursePolicy::class, 'create']);
            Gate::define('update-course', [CoursePolicy::class, 'update']);
            Gate::define('delete-course', [CoursePolicy::class, 'delete']);
        
            // Définition des gates pour le modèle Progress
            Gate::define('viewAny-progress', [ProgressPolicy::class, 'viewAny']);
            Gate::define('view-progress', [ProgressPolicy::class, 'view']);
            Gate::define('update-progress', [ProgressPolicy::class, 'update']);
        
            // Définition des gates pour le modèle Quiz
            Gate::define('view-quiz', [QuizPolicy::class, 'view']);
            Gate::define('create-quiz', [QuizPolicy::class, 'create']);
            Gate::define('update-quiz', [QuizPolicy::class, 'update']);
            Gate::define('delete-quiz', [QuizPolicy::class, 'delete']);
        
            // Définition des gates pour le modèle Question
            Gate::define('create-question', [QuestionPolicy::class, 'create']);
            Gate::define('update-question', [QuestionPolicy::class, 'update']);
            Gate::define('delete-question', [QuestionPolicy::class, 'delete']);
        
            // Définition des gates pour le modèle Choice
            Gate::define('create-choice', [ChoicePolicy::class, 'create']);
            Gate::define('update-choice', [ChoicePolicy::class, 'update']);
            Gate::define('delete-choice', [ChoicePolicy::class, 'delete']);
        
            // Définition des gates pour le modèle Answer
            Gate::define('create-answer', [AnswerPolicy::class, 'create']);
            Gate::define('view-answer', [AnswerPolicy::class, 'view']);
        }
        
}
