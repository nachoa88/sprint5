<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    public function deckCards()
    {
        return $this->hasMany(DeckCard::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
