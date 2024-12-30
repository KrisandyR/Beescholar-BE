<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->activity_name,
            'type' => $this->type,
            'description' => $this->description,
            'isRepeatable' => $this->is_repeatable,
            'completionPoint' => $this->completion_point,
            'priority' => $this->priority,
            'startSceneId' => $this->start_scene_id,
            'isCompleted' => $this->is_completed,
        ];
    }
}
