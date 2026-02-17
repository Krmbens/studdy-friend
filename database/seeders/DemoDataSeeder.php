<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or Find Demo User
        $user = null;
        try {
            echo "Creating demo user...\n";
            $user = User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Étudiant Démo',
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            echo "User ready: " . $user->id . "\n";
        } catch (\Throwable $e) {
            echo "User creation failed: " . $e->getMessage() . "\n";
            return;
        }

        // 2. Seed Assignments
        try {
            \App\Models\Assignment::factory()->count(10)->create(['user_id' => $user->id]);
            echo "Assignments seeded.\n";
        } catch (\Throwable $e) {
            echo "Assignments failed: " . $e->getMessage() . "\n";
        }
        
        // 3. Seed Study Sessions
        try {
            \App\Models\StudySession::factory()->count(15)->create(['user_id' => $user->id]);
            echo "Study Sessions seeded.\n";
        } catch (\Throwable $e) {
            echo "Study Sessions failed: " . $e->getMessage() . "\n";
        }
        
        // 4. Seed AI Study Tips
        try {
            \App\Models\AiStudyTip::factory()->count(8)->create(['user_id' => $user->id]);
            echo "AI Study Tips seeded.\n";
        } catch (\Throwable $e) {
            echo "AI Study Tips failed: " . $e->getMessage() . "\n";
        }
        
        // 5. Seed Document Summaries
        try {
            \App\Models\DocumentSummary::factory()->count(5)->create(['user_id' => $user->id]);
            echo "Document Summaries seeded.\n";
        } catch (\Throwable $e) {
            echo "Document Summaries failed: " . $e->getMessage() . "\n";
        }
        
        // 6. Seed Exercise Solutions
        try {
            \App\Models\ExerciseSolution::factory()->count(5)->create(['user_id' => $user->id]);
            echo "Exercise Solutions seeded.\n";
        } catch (\Throwable $e) {
            echo "Exercise Solutions failed: " . $e->getMessage() . "\n";
        }
        
        // 7. Seed Quizzes with Questions
        try {
            \App\Models\Quiz::factory()
                ->count(3)
                ->has(\App\Models\QuizQuestion::factory()->count(10), 'questions')
                ->create(['user_id' => $user->id]);
            echo "Quizzes seeded.\n";
        } catch (\Throwable $e) {
            echo "Quizzes failed: " . $e->getMessage() . "\n";
        }
            
        // 8. Seed Flashcard Decks with Cards
        try {
            \App\Models\FlashcardDeck::factory()
                ->count(3)
                ->has(\App\Models\Flashcard::factory()->count(15), 'flashcards')
                ->create(['user_id' => $user->id]);
            echo "Flashcards seeded.\n";
        } catch (\Throwable $e) {
            echo "Flashcards failed: " . $e->getMessage() . "\n";
        }
            
        echo "Application seeded with demo data for test@example.com\n";
    }
}
