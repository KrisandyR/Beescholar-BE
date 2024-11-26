<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizAnswer extends UserMinigameAnswer
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'is_correct',
        'questionType',
        'answer_steps_id',
        'option_id',
        'question_id',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'answer_steps_id' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(QuizOption::class, 'option_id');
    }
}
