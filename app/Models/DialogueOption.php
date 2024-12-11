<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DialogueOption extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'option_text',
        'dialogue_id',
        'next_scene_id', // nullable
        'created_by',
        'updated_by',
    ];

    public function dialogue()
    {
        return $this->belongsTo(Dialogue::class, 'dialogue_id', 'id');
    }

    public function nextScene()
    {
        return $this->belongsTo(Scene::class, 'next_scene_id', 'id');
    }
}
