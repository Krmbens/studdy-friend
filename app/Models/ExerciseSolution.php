<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseSolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'problem_statement',
        'solution_content',
        'image_path',
        'is_mock',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
