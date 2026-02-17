<?php

namespace Database\Factories;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlashcardFactory extends Factory
{
    protected $model = Flashcard::class;

    public function definition(): array
    {
        return [
            'flashcard_deck_id' => \App\Models\FlashcardDeck::factory(),
            'front_content' => $this->faker->sentence(5),
            'back_content' => $this->faker->sentence(10),
            'box_level' => $this->faker->numberBetween(1, 5),
        ];
    }
}
