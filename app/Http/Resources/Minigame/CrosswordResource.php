<?php

namespace App\Http\Resources\Minigame;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrosswordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'minigameId' => $this->minigame_id,
            'minigameName' => $this->minigame_name,
            'minigameType' => config('minigame_types')[$this->minigameable_type] ?? 'Unknown',
            'instruction' => $this->instruction,
            'maximumPointReward' => $this->maximum_point_reward,
            'minimumPassingPoint' => $this->minimum_passing_point, // default 0
            'crosswordId' => $this->id,
            'theme' => $this->theme,
            'words' => CrosswordWordResource::collection($this->words)
        ];
    }
}
