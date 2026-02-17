<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiStudyTip extends Model
{
    /** @use HasFactory<\Database\Factories\AiStudyTipFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject', 'tip_content', 
        'days_until_exam', 'generated_at', 'metadata', 'is_favorite'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'metadata' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
