<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('marque', 50);
            $table->string('modele', 50);
            $table->string('immatriculation', 20)->unique();
            $table->date('date_achat');
            $table->integer('kilometrage');
            $table->date('prochaine_maintenance');
            $table->enum('statut', ['disponible', 'en maintenance', 'hors service']);
            
            $table->foreignId('admin_id')->constrained('users');
            
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};