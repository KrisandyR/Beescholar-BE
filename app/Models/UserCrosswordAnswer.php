<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCrosswordAnswer extends UserMinigameAnswer
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'word_answer',
        'is_correct',
        'word_id',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function word()
    {
        return $this->belongsTo(CrosswordWord::class, 'word_id');
    }
}
