<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizOrderStepsAnswerDetail extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'answer_step_id',
        'answer_step_order',
        'user_answer_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'answer_step_order' => 'integer'
    ];

    public function answer()
    {
        return $this->belongsTo(QuizOrderStepsAnswer::class, 'user_answer_id', 'id');
    }

    public function steps()
    {
        return $this->belongsTo(QuizStep::class, 'answer_step_id', 'id');
    }
}
