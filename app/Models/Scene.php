<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'background',
        'is_start_scene', // default false
        'is_end_scene', // default false
        'next_scene_id', // nullable
        'activity_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_end_scene' => 'boolean',
        'is_start_scene' => 'boolean',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
    
    public function nextScene()
    {
        return $this->belongsTo(Scene::class, 'next_scene_id', 'id');
    }

    public function unlockedByScene()
    {
        return $this->hasOne(Scene::class, 'next_scene_id', 'id');
    }

    public function unlockedByDialogueOption()
    {
        return $this->hasMany(DialogueOption::class, 'next_scene_id', 'id');
    }

    public function dialogue()
    {
        return $this->hasOne(Dialogue::class, 'id', 'id');
    }

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'id');
    }

    public function minigame()
    {
        return $this->hasOne(Minigame::class, 'id', 'id');
    }

}
