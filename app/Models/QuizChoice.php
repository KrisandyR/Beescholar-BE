<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizChoice extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'option_text',
        'is_correct', // default false
        'question_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id', 'id');
    }

    public function quizMultipleChoiceAnswer()
    {
        return $this->hasMany(QuizMultipleChoiceAnswer::class, 'answer_option_id', 'id');
    }
}
