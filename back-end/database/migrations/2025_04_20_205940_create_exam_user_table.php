<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exam_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('present')->default(false);
            $table->enum('resultat', ['excellent', 'tres_bien', 'bien', 'moyen', 'insuffisant'])->nullable();
            $table->integer('score')->nullable();
            $table->text('observations')->nullable();
            $table->text('feedbacks')->nullable();
            $table->timestamps();

            $table->unique(['exam_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_user');
    }
};