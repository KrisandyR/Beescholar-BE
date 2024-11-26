<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'activity_name',
        'type',
        'description',
        'is_repeatable',
        'priority',
        'quest_id',
        'room_id',
        'scene_start_id',
        'unlock_activity_id',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_repeatable' => 'boolean',
        'priority' => 'integer',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function activityProgress()
    {
        return $this->hasMany(ActivityProgress::class);
    }

    public function scenes()
    {
        return $this->hasMany(Scene::class);
    }
}
