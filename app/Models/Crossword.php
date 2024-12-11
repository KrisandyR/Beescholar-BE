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
        'grid_size',
        'theme',
    ];

    protected $casts = [
        'grid_size' => 'integer'
    ];

    public function minigame()
    {
        return $this->belongsTo(Minigame::class, 'id', 'id');
    }

    public function crosswordWords()
    {
        return $this->hasMany(CrosswordWord::class, 'crossword_id', 'id');
    }
}
