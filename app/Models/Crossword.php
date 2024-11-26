<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crossword extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'grid_size',
        'theme',
    ];

    public function words()
    {
        return $this->hasMany(CrosswordWord::class, 'crossword_id');
    }
}
