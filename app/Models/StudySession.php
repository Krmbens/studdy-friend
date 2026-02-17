<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    /** @use HasFactory<\Database\Factories\StudySessionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject', 'duration_minutes', 
        'session_date', 'notes'
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
