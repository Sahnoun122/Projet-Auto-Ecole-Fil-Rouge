<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['theorique', 'pratique']);
            $table->dateTime('date_exam');
            $table->string('lieu', 100);
            $table->integer('places_max');
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'annule'])->default('planifie');
            $table->integer('nombre_presents')->default(0);
            $table->float('taux_reussite')->nullable();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('moniteur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('instructions')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('exam_candidat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidat_id')->constrained('users')->onDelete('cascade');
            $table->boolean('present')->default(false);
            $table->enum('resultat', ['excellent', 'tres_bien', 'bien', 'moyen', 'insuffisant'])->nullable();
            $table->integer('score')->nullable();
            $table->text('observations')->nullable();
            $table->text('feedbacks')->nullable();
            $table->timestamps();

            $table->unique(['exam_id', 'candidat_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_candidat');
        Schema::dropIfExists('exams');
    }
};