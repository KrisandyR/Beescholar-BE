<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'activity_name',
        'type',
        'description',
        'is_repeatable',
        'completion_point',
        'priority', // default 1, lower value means higher priority
        'quest_id', // nullable -> activity non quest
        'room_id', // nullable -> activity non room based
        'unlock_activity_id', // nullable
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_repeatable' => 'boolean',
        'completion_point' => 'integer',
        'priority' => 'integer',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function quest()
    {
        return $this->belongsTo(Quest::class, 'quest_id', 'id');
    }

    public function unlockActivity()
    {
        return $this->belongsTo(Activity::class, 'unlock_activity_id', 'id');
    }

    public function activityProgress()
    {
        return $this->hasMany(ActivityProgress::class, 'activity_id', 'id');
    }

    public function scenes()
    {
        return $this->hasMany(Scene::class, 'activity_id', 'id');
    }
}
