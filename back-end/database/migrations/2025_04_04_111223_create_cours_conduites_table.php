<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cours_conduites', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_heure');
            $table->integer('duree_minutes');
            $table->enum('statut', ['planifie', 'termine', 'annule'])->default('planifie');
            $table->foreignId('moniteur_id')->constrained('users');
            $table->foreignId('vehicule_id')->constrained();
            $table->foreignId('admin_id')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('presences_cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_conduite_id')->constrained('cours_conduites');
            $table->foreignId('candidat_id')->constrained('users');
            $table->boolean('present')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presences_cours');
        Schema::dropIfExists('cours_conduites');
    }
};