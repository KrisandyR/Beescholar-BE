<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'campus_name',
        'description',
        'created_by',
        'last_updated_by',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function campusProgress()
    {
        return $this->hasMany(CampusProgress::class);
    }
}
