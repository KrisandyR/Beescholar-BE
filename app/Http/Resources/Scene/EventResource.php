<?php

namespace App\Http\Resources\Scene;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'eventId' => $this->id,
            'eventName' => $this->event_name,
            'eventType' => $this->event_type
        ];
    }
}
