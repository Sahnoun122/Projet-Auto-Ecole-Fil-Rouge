<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences_cours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cours_conduite_id');
            $table->unsignedBigInteger('candidat_id');
            $table->boolean('present')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('cours_conduite_id')->references('id')->on('cours_conduites')->onDelete('cascade');
            $table->foreign('candidat_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['cours_conduite_id', 'candidat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presences_cours');
    }
}