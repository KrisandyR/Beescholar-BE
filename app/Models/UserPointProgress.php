<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPointProgress extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'point_gained', // default 0
        'point_source',
        'user_id',
        'quest_progress_id',
        'activity_progress_id',
        'minigame_attempt_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'point_gained' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function questProgress()
    {
        return $this->belongsTo(QuestProgress::class, 'quest_progress_id', 'id');
    }

    public function activityProgress()
    {
        return $this->belongsTo(ActivityProgress::class, 'activity_progress_id', 'id');
    }

    public function minigameAttempt()
    {
        return $this->belongsTo(MinigameAttempt::class, 'minigame_attempt_id', 'id');
    }
}
