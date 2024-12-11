<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityProgress extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'is_completed', // default false
        'completion_date', // nullable
        'activity_id',
        'user_id',
        'last_scene_id', // nullable
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completion_date' => 'datetime'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lastScene() {
        return $this->belongsTo(Scene::class, 'last_scene_id', 'id');
    }

    public function userPointProgress() {
        return $this->hasOne(UserPointProgress::class, 'activity_progress_id', 'id');
    }
}
