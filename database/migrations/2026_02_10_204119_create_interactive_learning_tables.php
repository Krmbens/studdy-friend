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
        // === QUIZ TABLES ===
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // e.g., "Photosynthesis Basics"
            $table->string('subject'); // e.g., "Biology"
            $table->text('source_content')->nullable(); // Original text used to gen quiz
            $table->integer('points_per_question')->default(10);
            $table->integer('total_score')->nullable(); // Score if taken immediately
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->string('type')->default('multiple_choice'); // multiple_choice, true_false
            $table->json('options'); // JSON array of options: ["A", "B", "C", "D"]
            $table->string('correct_answer'); // The correct option
            $table->text('explanation')->nullable(); // Why it's correct
            $table->timestamps();
        });


        // === DOCUMENT SUMMARIES TABLE ===
        Schema::create('document_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('original_content'); // The full text or excerpt
            $table->string('source_type')->default('text'); // text, file
            $table->text('summary_content'); // The AI generated summary
            $table->json('key_points')->nullable(); // Array of bullet points if separated
            $table->integer('original_length')->nullable(); // char count
            $table->integer('summary_length')->nullable(); // char count
            $table->timestamps();
        });


        // === FLASHCARDS TABLES ===
        Schema::create('flashcard_decks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g., "History Chapter 1"
            $table->string('subject')->nullable();
            $table->integer('total_cards')->default(0);
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flashcard_deck_id')->constrained()->cascadeOnDelete();
            $table->text('front_content'); // Question / Term
            $table->text('back_content'); // Answer / Definition
            $table->integer('box_level')->default(1); // For spaced repetition (1-5)
            $table->timestamp('next_review_date')->nullable(); // When is it due?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('flashcard_decks');
        Schema::dropIfExists('document_summaries');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
