<?php

namespace App\Http\Resources\Leaderboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardClearTimeResource extends JsonResource
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
            'name' => $this->name,
            'userCode' => $this->user_code,
            'profilePicture' => $this->profile_picture,
            'completionDate' => optional($this->completion_date)->format('Y-m-d H:i') ?? 'Not completed yet',
            'rank' => $this->rank
        ];
    }
}
