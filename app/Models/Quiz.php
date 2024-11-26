<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'question_title',
        'question_description',
        'question_code',
        'question_type',
        'question_point',
        'hint',
        'character_id',
        'created_by',
        'last_updated_by',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function options()
    {
        return $this->hasMany(QuizOption::class, 'question_id');
    }

    public function steps()
    {
        return $this->hasMany(QuizStep::class, 'question_id');
    }
}
