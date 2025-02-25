<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestActivityResource extends JsonResource
{
    public function toArray($request)
    {
        if($this->type && $this->type == 'Trivial Task'){
            return new ActivityResource($this);
        }
        return [
            'id' => $this->id,
            'questTitle' => $this->title,
            'description' => $this->description,
            'dateStart' => $this->date_start,
            'dateEnd' => $this->date_end,
            'activities' => ActivityResource::collection($this->activities),
        ];
    }
}
