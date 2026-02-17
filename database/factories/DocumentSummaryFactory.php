<?php

namespace Database\Factories;

use App\Models\DocumentSummary;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentSummaryFactory extends Factory
{
    protected $model = DocumentSummary::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'original_content' => $this->faker->text(1000),
            'summary_content' => $this->faker->text(300),
            'original_length' => 1000,
            'summary_length' => 300,
            'is_mock' => true,
            'source_type' => 'text',
        ];
    }
}
