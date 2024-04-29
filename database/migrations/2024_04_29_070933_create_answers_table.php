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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('flashcard_id');
            $table->enum('difficulty_level', ['easy', 'medium', 'hard']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('flashcard_id')->references('id')->on('flashcards')->onDelete('cascade');
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
