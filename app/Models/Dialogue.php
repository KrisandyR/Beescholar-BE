<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialogue extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'character_id', // nullable
        'dialogue_text',
    ];

    public function scene()
    {
        return $this->morphOne(Scene::class, 'sceneable');
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id', 'id');
    }

    public function dialogueOptions()
    {
        return $this->hasMany(DialogueOption::class, 'dialogue_id', 'id');
    }
}
