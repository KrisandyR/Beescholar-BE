<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'campus_id',
        'room_name',
        'type',
        'background',
        'created_by',
        'updated_by',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'room_id', 'id');
    }
}
