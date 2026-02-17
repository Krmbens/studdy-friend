<?php

namespace Database\Factories;

use App\Models\FlashcardDeck;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlashcardDeckFactory extends Factory
{
    protected $model = FlashcardDeck::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->sentence(3),
            'subject' => $this->faker->randomElement(['Mathématiques', 'Physique', 'Informatique', 'Français', 'Anglais', 'Autre']),
            'total_cards' => 0,
            'is_mock' => true,
        ];
    }
}
