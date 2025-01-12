<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\ActivityProgress;
use App\Models\Quest;
use App\Models\QuestProgress;
use App\Models\Scene;
use App\Models\UserPointProgress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class PointService
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function getPointFromQuest(string $userId, $questProgress): void
    {
        $pointProgress = UserPointProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'quest_progress_id' => $questProgress->id
            ],
            [
                'user_id' => $userId,
                'quest_progress_id' => $questProgress->id,
                'status' => 'Completed',
                'point_gained' => $questProgress->quest()->first()->completion_point,
                'point_source' => 'Quest'
            ]
        );

        $this->userService->updateUserTotalPoint($userId, $pointProgress->point_gained);
    }

    public function getPointFromActivity(string $userId, $activityProgress): void
    {
        $pointProgress = UserPointProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'activity_progress_id' => $activityProgress->id
            ],
            [
                'user_id' => $userId,
                'activity_progress_id' => $activityProgress->id,
                'status' => 'Completed',
                'point_gained' => $activityProgress->activity()->first()->completion_point,
                'point_source' => 'Activity'
            ]
        );

        $this->userService->updateUserTotalPoint($userId, $pointProgress->point_gained);
    }

    public function getPointFromMinigame(string $userId, $minigameAttempt){

        $userPointProgress = UserPointProgress::where('user_id', $userId)
            ->where('minigame_attempt_id', $minigameAttempt->id)->first();

        if ($userPointProgress) {
            $pointGained = $minigameAttempt->total_point - $userPointProgress->point_gained;
            // Update the existing record
            $userPointProgress->update([
                'status' => 'Completed',
                'point_gained' => $minigameAttempt->total_point,
                'point_source' => 'Minigame',
            ]);
        } else {
            // Create a new record
            $pointGained = $minigameAttempt->total_point;
            UserPointProgress::create([
                'user_id' => $userId,
                'minigame_attempt_id' => $minigameAttempt->id,
                'status' => 'Completed',
                'point_gained' => $minigameAttempt->total_point,
                'point_source' => 'Minigame',
            ]);
            
        }

        $this->userService->updateUserTotalPoint($userId, $pointGained);
    }
}
