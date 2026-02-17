<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->index(['user_id', 'completed', 'deadline']);
        });
        
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->index(['user_id', 'session_date']);
        });
        
        Schema::table('ai_study_tips', function (Blueprint $table) {
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'completed', 'deadline']);
        });
        
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'session_date']);
        });
        
        Schema::table('ai_study_tips', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'created_at']);
        });
    }
};
