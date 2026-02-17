<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'subject', 'source_content', 'total_score', 'is_completed', 'is_mock'];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
