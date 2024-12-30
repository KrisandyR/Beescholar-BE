<?php

namespace App\Http\Controllers;

use App\Models\Scene;
use App\Services\ActivityService;
use App\Services\QuestService;
use App\Services\SceneService;
use Illuminate\Http\Request;

class SceneController extends Controller
{
    protected $sceneService;
    protected $activityService;
    protected $questService;

    public function __construct(SceneService $sceneService, ActivityService $activityService, QuestService $questService)
    {
        $this->sceneService = $sceneService;
        $this->activityService = $activityService;
        $this->questService = $questService;
    }
    public function getScene($sceneId)
    {
        try{
            if(!$this->sceneService->getScene($sceneId)){
                return response()->json([
                    'success' => false,
                    'message' => 'Scene not found',
                ], 404);
            }

            $data = $this->sceneService->getSceneDetail($sceneId);

            return response()->json([
                'success' => true,
                'message' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }

    public function processScene($sceneId) {
        try{
            //Implement auth userId
            $userId = config('constants.default_user_id');
            $scene = $this->sceneService->getScene($sceneId);

            if(!$scene){
                return response()->json([
                    'success' => false,
                    'message' => 'Scene not found',
                ], 404);
            }

            $activityCompletionPerformed = $this->activityService->progressUserActivity($userId, $scene);

            if($activityCompletionPerformed){
                $this->questService->progressUserQuest($userId, $scene->activity_id);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Scene succesfully processed',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }
    
}
