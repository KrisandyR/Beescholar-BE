<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DialogueOption extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'dialogue_text',
        'dialogue_id',
        'next_scene_id',
        'created_by',
        'last_updated_by',
    ];

    public function dialogue()
    {
        return $this->belongsTo(Dialogue::class);
    }

    public function nextScene()
    {
        return $this->belongsTo(Scene::class, 'next_scene_id');
    }
}
