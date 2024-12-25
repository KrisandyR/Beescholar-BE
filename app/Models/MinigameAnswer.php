<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinigameAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'answer_point', // default 0
        'status',
        'minigame_attempt_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'answer_point' => 'integer'
    ];

    public function attempt()
    {
        return $this->belongsTo(MinigameAttempt::class, 'minigame_attempt_id', 'id');
    }

    public function answerable(){
        return $this->morphTo();
    }
}
