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
