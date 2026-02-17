<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        
        if (!$user) return;

        \App\Models\Assignment::create([
            'user_id' => $user->id,
            'title' => 'Projet Laravel',
            'subject' => 'Développement Web',
            'description' => 'Créer application AI assistant',
            'deadline' => now()->addDays(10),
            'priority' => 'high',
        ]);
        
        \App\Models\Assignment::create([
            'user_id' => $user->id,
            'title' => 'Examen Base de données',
            'subject' => 'MySQL',
            'deadline' => now()->addDays(7),
            'priority' => 'medium',
        ]);
    }
}
