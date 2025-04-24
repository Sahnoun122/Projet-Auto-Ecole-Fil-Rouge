// database/migrations/xxxx_xx_xx_create_progress_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTable extends Migration
{
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('course_id')->nullable(); 
            $table->unsignedBigInteger('quiz_id')->nullable(); 
            $table->integer('progress_percentage')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->json('details')->nullable(); 
            
            $table->foreign('candidate_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            
            $table->timestamps();
            
            $table->unique(['candidate_id', 'course_id', 'quiz_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('progress');
    }
}