<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudySession>
 */
class StudySessionFactory extends Factory
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
            'subject' => $this->faker->randomElement(['Mathématiques', 'Physique', 'Informatique', 'Français', 'Anglais', 'Autre']),
            'duration_minutes' => $this->faker->numberBetween(30, 180),
            'session_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'notes' => $this->faker->sentence(),
        ];
    }
}
