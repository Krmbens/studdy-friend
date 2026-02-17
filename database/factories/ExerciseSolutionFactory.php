<?php

namespace Database\Factories;

use App\Models\ExerciseSolution;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseSolutionFactory extends Factory
{
    protected $model = ExerciseSolution::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'subject' => $this->faker->randomElement(['Mathématiques', 'Physique', 'Informatique', 'Français', 'Anglais', 'Autre']),
            'problem_statement' => $this->faker->paragraph(),
            'solution_content' => $this->faker->text(500),
            'is_mock' => true,
        ];
    }
}
