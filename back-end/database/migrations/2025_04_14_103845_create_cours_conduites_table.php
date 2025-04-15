<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cours_conduites', function (Blueprint $table) {
            $table->id();  // Crée un champ 'id' de type auto-incrémenté
            $table->dateTime('date_heure');  // Crée un champ pour la date et l'heure
            $table->integer('duree_minutes');  // Crée un champ pour la durée en minutes
            $table->enum('statut', ['planifie', 'termine', 'annule'])->default('planifie');  // Crée un champ pour le statut avec une valeur par défaut
            $table->softDeletes();  // Crée un champ 'deleted_at' pour le soft delete
            $table->timestamps();  // Crée les champs 'created_at' et 'updated_at'
            $table->foreignId('moniteur_id')->constrained('users', 'id')->onDelete('cascade'); 
            $table->foreignId('vehicule_id')->constrained('vehicles', 'id')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users', 'id')->onDelete('cascade'); 
 

        });
    }

    public function down()
    {
        Schema::dropIfExists('cours_conduites');  // Supprime la table 'cours_conduites' si elle existe
    }
};
