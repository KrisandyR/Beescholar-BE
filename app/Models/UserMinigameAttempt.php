<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMinigameAttempt extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'total_point',
        'status',
        'minigame_type',
        'minigame_id',
        'user_id',
    ];

    public function answers()
    {
        return $this->hasMany(UserMinigameAnswer::class, 'user_minigame_attempt_id');
    }
}
