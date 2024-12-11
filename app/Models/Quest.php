<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'description',
        'unlock_campus_id', //Nullable
        'unlock_quest_id', //Nullable
        'unlock_activity_id', //Nullable
        'completion_point', // Default 0
        'date_start', // Nullable
        'date_end', // Nullable
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'completion_point' => 'integer',
        'date_start' => 'datetime',
        'date_end' => 'datetime'
    ];

    public function questProgress()
    {
        return $this->hasMany(QuestProgress::class, 'quest_id', 'id');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class,'quest_id', 'id');
    }

    public function unlockedByQuest()
    {
        return $this->hasOne(Quest::class, 'unlock_quest_id', 'id');
    }

    public function unlockQuest()
    {
        return $this->belongsTo(Quest::class, 'unlock_quest_id', 'id');
    }

    public function unlockActivity()
    {
        return $this->belongsTo(Activity::class, 'unlock_activity_id', 'id');
    }

    public function unlockCampus()
    {
        return $this->belongsTo(Campus::class, 'unlock_campus_id', 'id');
    }

}