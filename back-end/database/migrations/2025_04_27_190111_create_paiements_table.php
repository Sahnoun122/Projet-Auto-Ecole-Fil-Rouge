<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->decimal('montant_total', 10, 2)->nullable(); 
            $table->enum('methode', ['espèce', 'virement', 'carte', 'chèque']);
            $table->enum('status', ['complet', 'en_attente', 'rejeté', 'partiel'])->default('en_attente'); 
            $table->dateTime('date_paiement');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('preuve_paiement')->nullable();
            $table->boolean('est_partiel')->default(false); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};