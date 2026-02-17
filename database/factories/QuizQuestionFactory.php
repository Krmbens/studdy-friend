<?php

namespace Database\Factories;

use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition(): array
    {
        $options = [
            $this->faker->word,
            $this->faker->word,
            $this->faker->word,
            $this->faker->word,
        ];
        
        $correctIndex = $this->faker->numberBetween(0, 3);

        return [
            'quiz_id' => \App\Models\Quiz::factory(),
            'question_text' => $this->faker->sentence(10) . '?',
            'type' => 'multiple_choice',
            'options' => $options,
            'correct_answer' => $options[$correctIndex],
            'explanation' => $this->faker->sentence(),
        ];
    }
}
