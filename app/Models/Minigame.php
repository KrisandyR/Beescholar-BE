<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minigame extends Scene
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'instruction',
        'maximum_point_reward',
        'minimum_passing_point',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'maximum_point_reward' => 'integer',
        'minimum_passing_point' => 'integer',
    ];
}
