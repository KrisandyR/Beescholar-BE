<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinigameAttempt extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'total_point', // default 0
        'status',
        'minigame_id',
        'user_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'total_point' => 'integer'
    ];

    public function answers()
    {
        return $this->hasMany(MinigameAnswer::class, 'minigame_attempt_id', 'id');
    }

    public function userPointProgress()
    {
        return $this->hasOne(UserPointProgress::class, 'minigame_attempt_id', 'id');
    }

    public function fromMinigame()
    {
        return $this->belongsTo(Minigame::class, 'minigame_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function addPoint($point)
    {
        return $this->increment('total_point', $point);
    }
}
