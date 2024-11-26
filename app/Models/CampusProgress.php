<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusProgress extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'campus_id',
        'is_locked',
        'is_story_locked',
        'is_semester_locked',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'is_story_locked' => 'boolean',
        'is_semester_locked' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
