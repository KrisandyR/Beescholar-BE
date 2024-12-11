<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizMultipleChoiceAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'answer_option_id',
        'is_correct' // default false
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function minigameAnswer()
    {
        return $this->belongsTo(MinigameAnswer::class, 'id', 'id');
    }

    public function options()
    {
        return $this->belongsTo(QuizOption::class, 'answer_option_id', 'id');
    }
}
