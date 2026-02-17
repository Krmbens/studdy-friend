<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashcardDeck extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'subject', 'total_cards', 'is_mock'];

    public function cards()
    {
        return $this->hasMany(Flashcard::class);
    }
}
