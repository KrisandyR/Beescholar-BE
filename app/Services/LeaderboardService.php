<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\ActivityProgress;
use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Crossword;
use App\Models\Minigame;
use App\Models\MinigameAttempt;
use App\Models\Quest;
use App\Models\QuestProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

use function PHPUnit\Framework\isEmpty;

class LeaderboardService
{
    public function getFromClearTime(string $userId){
        $topUsers = User::whereNotNull('completion_date') // Ensure completion_date is not null
            ->orderBy('completion_date', 'asc')          // Primary order by completion_date
            ->orderBy('total_point', 'desc')             // Secondary order by total_point
            ->take(10)                                   // Limit to top 10 users
            ->get();

        $currentUser = User::find($userId);

        return collect([
            'topUsers' => $topUsers,
            'currentUser' => $currentUser,
        ]);
    }

    public function getFromPoint(string $userId){
        $topUsers = User::whereNotNull('completion_date') // Ensure completion_date is not null
            ->orderBy('total_point', 'desc')
            ->orderBy('completion_date', 'asc')          // Primary order by completion_date           // Secondary order by total_point
            ->take(10)                                   // Limit to top 10 users
            ->get();

        $currentUser = User::find($userId);

        return collect([
            'topUsers' => $topUsers,
            'currentUser' => $currentUser,
        ]);
    }

    public function getFromCrossword(string $userId){
        
    }

    public function getUserGameStats(string $userId)
    {
        $user = User::find($userId);

        if (!$user){
            return [];
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'totalPoint' => $user->total_point,
            'completionDate' => $user->completion_date,
        ];

        $activityProgress = $this->getUserActivityProgress($userId);
        $questProgress = $this->getUserQuestProgress($userId);
        $crosswordProgress = $this->getUserCrosswordProgress($userId);
        $campusProgress = $this->getUserCampusProgress($userId);
        $trivialTaskProgress = $this->getUserTrivialTaskProgress($userId);

        return array_merge(
            $userData,
            $activityProgress,
            $questProgress,
            $crosswordProgress,
            $campusProgress,
            $trivialTaskProgress
        );
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
}
