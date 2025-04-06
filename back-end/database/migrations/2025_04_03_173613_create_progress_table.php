<?php
// database/migrations/xxxx_xx_xx_create_progress_table.php
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
            $table->unsignedBigInteger('course_id');
            $table->foreign('candidate_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->integer('progress_percentage')->default(0);
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('progress');
    }
}
