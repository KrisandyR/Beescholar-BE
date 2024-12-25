<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrosswordAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'word_answer',
        'is_correct', // default false
        'word_id',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function minigameAnswer()
    {
        return $this->morphOne(MinigameAnswer::class, 'answerable');
    }

    public function crosswordWord()
    {
        return $this->belongsTo(CrosswordWord::class, 'word_id', 'id');
    }
}
