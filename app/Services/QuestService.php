<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\ActivityProgress;
use App\Models\Quest;
use App\Models\QuestProgress;
use App\Models\Scene;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class QuestService
{
    protected $pointService;
    protected $activityService;

    public function __construct(PointService $pointService, ActivityService $activityService)
    {
        $this->pointService = $pointService;
        $this->activityService = $activityService;
    }
    public function progressUserQuest(string $userId, $activityId): void
    {
        $activity = Activity::findOrFail($activityId);
        $questId = $activity->quest_id;

        $quest = Quest::findOrFail($questId);

        $progress = QuestProgress::where('user_id', $userId)
            ->where('quest_id', $questId)
            ->first();

        $commonValues = [
            'updated_by' => 'progressUserActivity' . $userId,
        ];

        if ($progress && !$progress->is_completed) {
            $questActivityIds = $activity->quest()->first()
                ->activity()->get()->pluck('id');
            $activityProgresses = ActivityProgress::where('user_id', $userId)->
                whereIn('activity_id', $questActivityIds)->get();
            $allActivityCompleted = $activityProgresses->every(function ($progress) {
                return $progress->is_completed;
            }) && $questActivityIds->count() == $activityProgresses->count();

            dump($allActivityCompleted, $questActivityIds->count(), $questActivityIds->count() == $activityProgresses->count());

            if(!$allActivityCompleted) {
                return;
            }

            $additionalValues = [
                'status' => 'Completed',
                'is_completed' => true,
                'completion_date' => now(),
            ];

            $values = array_merge($commonValues, $additionalValues);

            $progress->update($values);

            $this->pointService->getPointFromQuest($userId, $progress);

            $this->unlockNextQuest($userId, $quest);
        } else {
            $values = array_merge($commonValues, [
                'status' => 'In Progress',
                'is_completed' => false,
                'completion_date' => null,
                'created_by' => 'progressUserQuest' . $userId,
                'user_id' => $userId,
                'quest_id' => $questId,
            ]);
            QuestProgress::create($values);
        }
    }

    public function unlockNextQuest($userId, $quest){
        QuestProgress::create([
            'status' => 'Incomplete',
            'is_completed' => false, // Default false
            'completion_date' => null, // Nullable
            'quest_id' => $quest->unlock_quest_id,
            'user_id' => $userId,
            'created_by' => 'unlockNextQuest'.$userId,
            'updated_by' => null,
        ]);

        $nextQuest = Quest::find($quest->unlock_quest_id);

        $this->activityService->unlockNextActivity($userId, $nextQuest->unlock_activity_id);
    }
}
