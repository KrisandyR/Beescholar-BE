<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'background',
        'is_activity_end',
        'is_starting_scene',
        'next_scene_id',
        'activity_id',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_activity_end' => 'boolean',
        'is_starting_scene' => 'boolean',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function nextScene()
    {
        return $this->belongsTo(Scene::class, 'next_scene_id');
    }
}
