<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidat', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('photo_identite');
            $table->string('type_permis');
            $table->unsignedBigInteger('id_candidat'); 
            $table->foreign('id_candidat')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_candidat'); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidat');
    }
};
