<?php

namespace App\Http\Resources\Leaderboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardPersonalStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'] ?? null,
            'name' => $this['name'] ?? null,
            'totalPoint' => $this['totalPoint'] ?? null,
            'completionDate' => $this['completionDate'] ?? null,
            'activityCompleted' => $this['activityCompleted'] ?? 0,
            'totalActivity' => $this['totalActivity'] ?? 0,
            'questCompleted' => $this['questCompleted'] ?? 0,
            'totalQuest' => $this['totalQuest'] ?? 0,
            'crosswordCompleted' => $this['crosswordCompleted'] ?? 0,
            'totalCrossword' => $this['totalCrossword'] ?? 0,
            'campusUnlocked' => $this['campusUnlocked'] ?? 0,
            'totalCampus' => $this['totalCampus'] ?? 0
        ];
    }
}
