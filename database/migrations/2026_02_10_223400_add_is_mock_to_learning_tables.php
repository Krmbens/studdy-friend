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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->boolean('is_mock')->default(false)->after('total_score');
        });

        Schema::table('document_summaries', function (Blueprint $table) {
            $table->boolean('is_mock')->default(false)->after('summary_length');
        });

        Schema::table('flashcard_decks', function (Blueprint $table) {
            $table->boolean('is_mock')->default(false)->after('total_cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('is_mock');
        });

        Schema::table('document_summaries', function (Blueprint $table) {
            $table->dropColumn('is_mock');
        });

        Schema::table('flashcard_decks', function (Blueprint $table) {
            $table->dropColumn('is_mock');
        });
    }
};
