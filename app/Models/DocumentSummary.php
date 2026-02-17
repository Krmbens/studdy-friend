<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSummary extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_content', 'summary_content', 'original_length', 'summary_length', 'source_type', 'is_mock', 'key_points'];

    protected $casts = [
        'key_points' => 'array',
    ];
}
