<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'théorique' ou 'pratique'
            $table->dateTime('date_exam');
            $table->string('lieu');
            $table->integer('places_max');
            $table->foreignId('admin_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('exam_candidat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('candidat_id')->constrained('users');
            $table->integer('resultat')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }
};