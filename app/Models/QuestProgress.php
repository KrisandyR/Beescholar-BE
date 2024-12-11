<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestProgress extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'is_completed', // Default false
        'completion_date', // Nullable
        'quest_id',
        'user_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completion_date' => 'datetime',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class, 'quest_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userPointProgress()
    {
        return $this->hasOne(UserPointProgress::class, 'quest_progress_id', 'id');
    }
}
