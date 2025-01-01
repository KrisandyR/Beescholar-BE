<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\ActivityProgress;
use App\Models\Quest;
use App\Models\Scene;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ActivityService
{
    protected $pointService;

    public function __construct(PointService $pointService)
    {
        $this->pointService = $pointService;
    }

    public function getQuestsWithActivities(string $roomId, string $userId): Collection
    {
        $activities = Activity::with([
                'activityProgress' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                },
                'firstScene' => function ($query) {
                    $query->where('is_start_scene', true);
                }
            ])
            ->where('room_id', $roomId)
            ->whereHas('activityProgress', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
    
        if ($activities->isEmpty()) {
            return new Collection(); // Return empty collection for error handling in controller
        }
    
        // Add dynamic fields to activities
        $activities->transform(function ($activity) {
            $activityProgress = $activity->activityProgress->first();
    
            // Determine start_scene_id
            $activity->start_scene_id = $activityProgress && $activityProgress->last_scene_id
                ? $activityProgress->last_scene_id
                : $activity->firstScene->first()?->id;
    
            // Set is_completed from activityProgress if it exists
            $activity->is_completed = $activityProgress?->is_completed ?? false;
    
            return $activity;
        });
    
        // Get unique quest IDs
        $questIds = $activities->pluck('quest_id')->unique()->values();

        // Prepare quests with their activities
        $questWithActivities = new Collection();
    
        foreach ($questIds as $questId) {
            $quest = Quest::findOrFail($questId); // Fetch the quest
            $quest->activities = $activities->where('quest_id', $questId); // Filter activities for this quest
    
            // Add quest to the collection
            $questWithActivities->push($quest);
        }
    
        return $questWithActivities;
    }

    public function progressUserActivity(string $userId, $scene)
    {
        // Retrieve the existing progress for the user and activity
        $activity = Activity::findOrFail($scene->activity_id);

        $progress = ActivityProgress::where('user_id', $userId)
            ->where('activity_id', $activity->id)
            ->first();
    
        $commonValues = [
            'last_scene_id' => $scene->id,
            'updated_by' => 'progressUserActivity' . $userId,
        ];

        $completionPerformed = false;
    
        if ($progress) {
            $completionPerformed = !$progress->is_completed && $scene->is_end_scene;
            // Determine values based on existing progress and scene type
            $additionalValues = $completionPerformed
                ? [
                    'status' => 'Completed',
                    'last_scene_id' => null,
                    'is_completed' => true,
                    'completion_date' => now(),
                ]
                : [];
                
            // Merge common values with specific updates
            $values = array_merge($commonValues, $additionalValues);
    
            // Update existing progress
            $progress->update($values);

            if($completionPerformed){
                $this->pointService->getPointFromActivity($userId, $progress);
                $this->unlockNextActivity($userId, $activity->unlock_activity_id);
                $completionPerformed = true;
            }

        } else {
            // Initialize values for new progress
            $values = array_merge($commonValues, [
                'status' => $scene->is_end_scene ? 'Completed' : 'In Progress',
                'is_completed' => $scene->is_end_scene,
                'completion_date' => $scene->is_end_scene ? now() : null,
                'created_by' => 'progressUserActivity' . $userId,
                'user_id' => $userId,
                'activity_id' => $scene->activity_id,
            ]);
    
            // Create new progress
            ActivityProgress::create($values);
        }

        return $completionPerformed;
    }

    public function unlockNextActivity($userId, $nextActivityId) {
        ActivityProgress::create([
            'status' => 'Incomplete',
            'is_completed' => false, // default false
            'completion_date' => null, // nullable
            'activity_id' => $nextActivityId,
            'user_id' => $userId,
            'last_scene_id' => null, // nullable
            'created_by' => 'unlockNextActivity'.$userId,
            'updated_by' => null,
        ]);
    }
}
