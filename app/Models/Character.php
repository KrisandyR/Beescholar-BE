<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'campus_id', // Nullable
        'character_name',
        'roles',
        'description',
        'gender',
        'likes',
        'dislikes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'roles' => 'array',
        'likes' => 'array',
        'dislikes' => 'array',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'id');
    }

    public function dialogues()
    {
        return $this->hasMany(Dialogue::class, 'character_id', 'id');
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class,'character_id', 'id');
    }
}