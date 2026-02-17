<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudySessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        
        if (!$user) return;

        \App\Models\StudySession::create([
            'user_id' => $user->id,
            'subject' => 'Informatique',
            'duration_minutes' => 60,
            'session_date' => now(),
            'notes' => 'Révision des bases de Laravel',
        ]);
    }
}
