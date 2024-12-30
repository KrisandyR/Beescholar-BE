<?php

namespace App\Http\Resources\Scene;

use Illuminate\Http\Resources\Json\JsonResource;

class DialogueOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'optionId' => $this->id,
            'optionText' => $this->option_text,
            'nextSceneId' => $this->next_scene_id,
        ];
    }
}
