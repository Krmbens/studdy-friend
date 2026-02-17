<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(3),
            'subject' => $this->faker->randomElement(['Mathématiques', 'Physique', 'Informatique', 'Français', 'Anglais', 'Autre']),
            'source_content' => $this->faker->paragraph(10),
            'total_score' => $this->faker->numberBetween(10, 100),
            'is_completed' => $this->faker->boolean(50),
            'is_mock' => true,
        ];
    }
}
