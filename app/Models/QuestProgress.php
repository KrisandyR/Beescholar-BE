<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestProgress extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'is_completed',
        'completion_date',
        'quest_id',
        'user_id',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completion_date' => 'datetime',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
