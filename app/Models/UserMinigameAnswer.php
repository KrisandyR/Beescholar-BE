<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMinigameAnswer extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'answer_point',
        'status',
        'user_minigame_attempt_id',
        'created_by',
        'last_updated_by',
    ];

    public function attempt()
    {
        return $this->belongsTo(UserMinigameAttempt::class, 'user_minigame_attempt_id');
    }
}
