<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\QuestActivityResource;
use App\Models\Activity;
use App\Models\Quest;
use App\Services\ActivityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }
    public function getActivityFromRoom(string $roomId)
    {
        try {
            $userId = config('constants.default_user_id');

            // Use service to get quests with activities
            $questWithActivities = $this->activityService->getQuestsWithActivities($roomId, $userId);

            $nonQuestActivities = $this->activityService->getNonQuestActivities($roomId, $userId);
    
            // Handle empty results
            if ($questWithActivities->isEmpty() && $nonQuestActivities->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No activities found for the specified room and user.',
                ], 204);
            }
    
            // Transform and return data
            return response()->json([
                'success' => true,
                'data' => (object) [
                    'questActivities' => QuestActivityResource::collection($questWithActivities),
                    'nonQuestActivites' => ActivityResource::collection($nonQuestActivities)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }

    }
}
