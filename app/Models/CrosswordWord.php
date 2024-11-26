<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrosswordWord extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'word_answer',
        'clue',
        'direction',
        'col_start_idx',
        'col_end_idx',
        'row_start_idx',
        'row_end_idx',
        'crossword_id',
    ];

    public function crossword()
    {
        return $this->belongsTo(Crossword::class, 'crossword_id');
    }
}
