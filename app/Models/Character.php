<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id',
        'character_name',
        'role',
        'description',
        'gender',
        'likes',
        'dislikes',
    ];

    protected $casts = [
        'likes' => 'array',
        'dislikes' => 'array',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}