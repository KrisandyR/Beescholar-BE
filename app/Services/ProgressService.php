<?php

namespace App\Services;

use App\Http\Resources\Scene\DialogueResource;
use App\Http\Resources\Scene\EventResource;
use App\Http\Resources\Scene\MinigameResource;
use App\Models\Activity;
use App\Models\ActivityProgress;
use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Crossword;
use App\Models\Dialogue;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\MinigameAttempt;
use App\Models\Quest;
use App\Models\QuestProgress;
use App\Models\Scene;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ProgressService {

    public function getUserProgress(string $userId)
    {
        $currentUser = User::findOrFail($userId);

        $userData = [
            'id' => $currentUser->id,
            'name' => $currentUser->name,
            'totalPoint' => $currentUser->total_point,
            'completionDate' => $currentUser->completion_date,
        ];

        return array_merge(
            $userData,
            $this->getUserActivityProgress($userId),
            $this->getUserQuestProgress($userId),
            $this->getUserCrosswordProgress($userId),
            $this->getUserCampusProgress($userId),
            $this->getUserTrivialTaskProgress($userId)
        );
    }

    public function getUserQuestProgress(string $userId)
    {
        $completedQuest = QuestProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();

        $totalQuest = Quest::count();

        return [
            'questCompleted' => $completedQuest,
            'totalQuest' => $totalQuest,
        ];
    }

    public function getUserActivityProgress(string $userId)
    {
        $userCompletedActivity = ActivityProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();

        $totalActivity = Activity::count();

        return [
            'activityCompleted' => $userCompletedActivity,
            'totalActivity' => $totalActivity,
        ];
    }

    public function getUserCampusProgress(string $userId)
    {
        $userCompletedCampus = CampusProgress::where('user_id', $userId)
            ->where('is_locked', false)
            ->count();

        $totalCampus = Campus::count();

        return [
            'campusUnlocked' => $userCompletedCampus,
            'totalCampus' => $totalCampus,
        ];
    }

    public function getUserTrivialTaskProgress(string $userId)
    {
        $trivialTaskIds = Activity::where('type', 'Trivial Task')
            ->pluck('id');

        $completedTrivialTask = ActivityProgress::where('user_id', $userId)
            ->whereIn('activity_id', $trivialTaskIds)
            ->where('is_completed', true)
            ->count();

        $totalTrivialTask = $trivialTaskIds->count();

        return [
            'trivialTaskCompleted' => $completedTrivialTask,
            'totaltrivialTask' => $totalTrivialTask,
        ];
    }

    public function getUserCrosswordProgress(string $userId)
    {
        $crosswordIds = Minigame::where('minigameable_type', Crossword::class)->pluck('id');

        $completedCrosswords = MinigameAttempt::where('user_id', $userId)
            ->whereIn('minigame_id', $crosswordIds)
            ->count();

        $totalCrossword= $crosswordIds->count();

        return [
            'crosswordCompleted' => $completedCrosswords,
            'totalCrossword' => $totalCrossword,
        ];
    }


}
