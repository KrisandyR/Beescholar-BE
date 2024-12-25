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
        return $this->morphOne(MinigameAnswer::class, 'answerable');
    }

    public function choice()
    {
        return $this->belongsTo(QuizChoice::class, 'answer_option_id', 'id');
    }
}
