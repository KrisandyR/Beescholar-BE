<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizOrderStepsAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'is_correct', // default false
        'question_id'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function minigameAnswer()
    {
        return $this->morphOne(MinigameAnswer::class, 'answerable');
    }

    public function details()
    {
        return $this->hasMany(QuizOrderStepsAnswerDetail::class, 'user_answer_id', 'id');
    }

}
