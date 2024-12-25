<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'role',
        'user_code',
        'academic_career',
        'total_point', // Default 0
        'completion_date', // Nullable
        'semester',
        'gender',
        'email',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'total_point' => 'integer',
        'completion_date' => 'datetime',
        'semester' => 'integer',
    ];

    public function campusProgress()
    {
        return $this->hasMany(CampusProgress::class, 'user_id', 'id');
    }

    public function questProgress()
    {
        return $this->hasMany(QuestProgress::class, 'user_id', 'id');
    }

    public function activityProgress()
    {
        return $this->hasMany(ActivityProgress::class, 'user_id', 'id');
    }

    public function minigameAttempt()
    {
        return $this->hasMany(MinigameAttempt::class, 'user_id', 'id');
    }
}
