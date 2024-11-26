<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPointProgress extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'point_gained',
        'point_source',
        'user_id',
        'quest_progress_id',
        'activity_progress_id',
        'user_minigame_attempt_id',
        'created_by',
        'last_updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function questProgress()
    {
        return $this->belongsTo(QuestProgress::class, 'quest_progress_id');
    }

    public function activityProgress()
    {
        return $this->belongsTo(ActivityProgress::class, 'activity_progress_id');
    }

    public function minigameAttempt()
    {
        return $this->belongsTo(UserMinigameAttempt::class, 'user_minigame_attempt_id');
    }
}
