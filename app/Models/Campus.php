<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'campus_name',
        'description',
        'minimum_semester', // Nullable
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'minimum_semester' => 'integer'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'campus_id', 'id');
    }

    public function characters()
    {
        return $this->hasMany(Character::class, 'campus_id', 'id');
    }

    public function campusProgress()
    {
        return $this->hasMany(CampusProgress::class, 'campus_id', 'id');
    }

    public function unlockedFromQuest()
    {
        return $this->hasOne(Quest::class, 'unlock_campus_id', 'id');
    }
}
