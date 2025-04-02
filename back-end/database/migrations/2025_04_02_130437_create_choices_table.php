<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // database/migrations/xxxx_xx_xx_create_choices_table.php
public function up()
{
    Schema::create('choices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('question_id')->constrained()->onDelete('cascade');
        $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
        $table->string('choice_text');
        $table->boolean('is_correct')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
