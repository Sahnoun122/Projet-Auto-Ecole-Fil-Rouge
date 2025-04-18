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
            $table->softDeletes(); 
            $table->timestamps();  
            $table->foreignId('moniteur_id')->constrained('users', 'id')->onDelete('cascade'); 
            $table->foreignId('vehicule_id')->constrained('vehicles', 'id')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users', 'id')->onDelete('cascade'); 
            $table->foreignId('candidat')->constrained('users', 'id')->onDelete('cascade'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('cours_conduites');  // Supprime la table 'cours_conduites' si elle existe
    }
};
