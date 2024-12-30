<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    public const TYPE_MULTIPLE_CHOICE = 'Multiple Choice';
    public const TYPE_YES_NO = 'Yes or No';
    public const TYPE_REORDER_STEPS = 'Reorder Steps';

    protected $fillable = [
        'id',
        'question_title',
        'question_type',
        'question_point',
        'character_id', // nullable
        'quiz_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'question_point' => 'integer'
    ];

    public function choices()
    {
        return $this->hasMany(QuizChoice::class, 'question_id', 'id');
    }

    public function steps()
    {
        return $this->hasMany(QuizStep::class, 'question_id', 'id');
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id', 'id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }
}
