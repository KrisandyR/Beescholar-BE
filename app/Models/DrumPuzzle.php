<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrumPuzzle extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'total_hit',
    ];
    
    protected $casts = [
        'total_hit' => 'integer'
    ];

    public function minigame()
    {
        return $this->morphOne(Minigame::class, 'minigameable');
    }
}