<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDrumPuzzleAnswer extends UserMinigameAnswer
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'pattern',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'pattern' => 'array',
    ];
}
