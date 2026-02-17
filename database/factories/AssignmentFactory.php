<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(4),
            'subject' => $this->faker->randomElement(['Mathématiques', 'Physique', 'Informatique', 'Français', 'Anglais', 'Autre']),
            'description' => $this->faker->paragraph(),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'completed' => $this->faker->boolean(30),
        ];
    }
}
