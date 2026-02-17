<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AiStudyTip>
 */
class AiStudyTipFactory extends Factory
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
            'tip_content' => $this->faker->paragraph(),
            'is_favorite' => $this->faker->boolean(20),
            'metadata' => ['tags' => ['exam', 'preparation']],
        ];
    }
}
