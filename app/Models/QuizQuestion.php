<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_text', 'type', 'options', 'correct_answer', 'explanation'];

    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Safety accessor to handle double-encoded JSON if it somehow occurs
     */
    public function getOptionsAttribute($value)
    {
        $options = $this->castAttribute('options', $value);
        if (is_string($options)) {
            return json_decode($options, true) ?: [];
        }
        return $options ?: [];
    }
}
