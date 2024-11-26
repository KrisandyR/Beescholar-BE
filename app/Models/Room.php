<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'campus_id',
        'room_name',
        'type',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
