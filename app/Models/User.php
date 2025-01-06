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

    public function addPoints($pointGained)
    {
        $this->increment('total_point', $pointGained);
    }

    public function calculateRankByClearTime()
    {
        if (is_null($this->completion_date)) {
            return User::whereNotNull('completion_date')->count() + 1;
        }

        return User::whereNotNull('completion_date')
            ->where(function ($query) {
                $query->where('completion_date', '>', $this->completion_date)
                    ->orWhere(function ($query) {
                        $query->where('completion_date', $this->completion_date)
                            ->where('total_point', '>', $this->total_point);
                    });
            })->count() + 1;
    }

    public function calculateRankByPoint()
    {
        return User::where(function ($query) {
            $query->where('total_point', '>', $this->total_point)
                ->orWhere(function ($query) {
                    $query->where('total_point', $this->total_point);

                    if (!is_null($this->completion_date)) {
                        $query->whereNotNull('completion_date')
                            ->where('completion_date', '<', $this->completion_date);
                    } else {
                        $query->whereNotNull('completion_date');
                    }
                });
        })->count() + 1;
    }
}
