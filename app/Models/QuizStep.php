<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizStep extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'step_text',
        'step_order',
        'question_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'step_order' => 'integer'
    ];

    public function quizStepsAnswerDetail()
    {
        return $this->hasMany(QuizOrderStepsAnswerDetail::class, 'answer_step_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id', 'id');
    }
    
}
