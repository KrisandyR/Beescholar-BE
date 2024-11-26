<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialogue extends Scene
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'character_id',
        'created_by',
        'last_updated_by',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function dialogueOptions()
    {
        return $this->hasMany(DialogueOption::class);
    }
}
