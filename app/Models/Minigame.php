<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minigame extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'minigame_name',
        'instruction',
        'maximum_point_reward',
        'minimum_passing_point', // default 0
    ];

    protected $casts = [
        'maximum_point_reward' => 'integer',
        'minimum_passing_point' => 'integer',
    ];

    public function scene()
    {
        return $this->morphOne(Scene::class, 'sceneable');
    }

    public function minigameable()
    {
        return $this->morphTo();
    }

    public function minigameAttempt()
    {
        return $this->hasMany(MinigameAttempt::class, 'minigame_id', 'id');
    }

}
