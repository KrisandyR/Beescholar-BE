<?php

namespace App\Http\Resources\Scene;

use Illuminate\Http\Resources\Json\JsonResource;

class DialogueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'sceneId' => $this->scene_id,
            'sceneType' => config('scene_types')[$this->sceneable_type] ?? 'Unknown',
            'background' => $this->background,
            'isStartScene' => $this->is_start_scene,
            'isEndScene' => $this->is_end_scene,
            'nextSceneId' => $this->next_scene_id,
            'dialogueId' => $this->id,
            'characterId' => $this->character_id,
            'characterName' => $this->character_name,
            'dialogueText' => $this->dialogue_text,
            'options' => DialogueOptionResource::collection($this->options)
        ];
    }
}
