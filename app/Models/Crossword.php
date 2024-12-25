<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crossword extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'theme',
    ];

    public function minigame()
    {
        return $this->morphOne(Minigame::class, 'minigameable');
    }

    public function crosswordWords()
    {
        return $this->hasMany(CrosswordWord::class, 'crossword_id', 'id');
    }
}
