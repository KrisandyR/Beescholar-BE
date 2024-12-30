<?php

namespace App\Http\Resources\Scene;

use Illuminate\Http\Resources\Json\JsonResource;

class MinigameResource extends JsonResource
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
            'minigameId' => $this->id,
            'minigameType' => config('minigame_types')[$this->minigameable_type] ?? 'Unknown',
        ];
    }
}
