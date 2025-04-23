<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidat_id')->constrained('users')->onDelete('cascade');
            $table->text('exam_feedback')->nullable();
            $table->text('school_comment')->nullable();
            $table->tinyInteger('school_rating')->default(0);
            $table->timestamps();
            
            $table->unique(['exam_id', 'candidat_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_feedbacks');
    }
};