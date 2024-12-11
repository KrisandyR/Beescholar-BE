<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrosswordWord extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'word_answer',
        'clue',
        'direction',
        'col_start_idx',
        'row_start_idx',
        'crossword_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'col_start_idx' => 'integer',
        'row_start_idx' => 'integer',
    ];

    public function crossword()
    {
        return $this->belongsTo(Crossword::class, 'crossword_id', 'id');
    }

    public function crosswordAnswers()
    {
        return $this->hasMany(CrosswordAnswer::class, 'word_id', 'id');
    }
}
