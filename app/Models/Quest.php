<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'description',
        'unlock_campus_id',
        'unlock_quest_id',
        'unlock_activity_id',
        'completion_point',
        'date_start',
        'date_end',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'completion_point' => 'integer',
        'date_start' => 'datetime',
        'date_end' => 'datetime',
    ];

    public function questProgress()
    {
        return $this->hasMany(QuestProgress::class);
    }
}
