<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrumPuzzleAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'pattern_answer',
    ];

    protected $casts = [
        'pattern_answer' => 'array'
    ];

    public function minigameAnswer()
    {
        return $this->morphOne(MinigameAnswer::class, 'answerable');
    }
}
