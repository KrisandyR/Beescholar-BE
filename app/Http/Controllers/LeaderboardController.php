<?php

namespace App\Http\Controllers;

use App\Http\Resources\Leaderboard\LeaderboardClearTimeResource;
use App\Http\Resources\Leaderboard\LeaderboardCrosswordResource;
use App\Http\Resources\Leaderboard\LeaderboardPersonalStatsResource;
use App\Http\Resources\Leaderboard\LeaderboardPointResource;
use App\Services\LeaderboardService;
use App\Services\ProgressService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    protected LeaderboardService $leaderboardService;
    protected ProgressService $progressService;
    

    public function __construct(LeaderboardService $leaderboardService, ProgressService $progressService)
    {
        $this->leaderboardService = $leaderboardService;
        $this->progressService = $progressService;
    }

    public function getLeaderboard(Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;
            $leaderboardType = $request->route('leaderboardType');
            // Resolve leaderboard data using the helper method
            $data = $this->resolveLeaderboardData($leaderboardType, $userId);

            // If the returned data is empty
            if ($data['topUsers']->isEmpty()) {
                $response = response()->json([
                    'success' => false,
                    'message' => 'Leaderboard is empty',
                ], 404);
            }
            elseif (empty($data['currentUser'])){
                $response = response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }
            else {
                $response = response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            }

            // Return a JSON response
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }

    public function getUserProgress(Request $request): JsonResponse
    {
        // add try catch
        $userId = $request->user()->id;
        $data = $this->progressService->getUserProgress($userId);

        if (empty($data)){
            $response =  response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        } else {
            $response = response()->json([
                'success' => true,
                'data' => new LeaderboardPersonalStatsResource($data),
            ]);
        }

        return $response;
    }


    private function resolveLeaderboardData(string $leaderboardType, string $userId): array
    {
        switch ($leaderboardType) {
            case 'clear_time':
                $data = $this->leaderboardService->getFromClearTime($userId);
                return [
                    'topUsers' => LeaderboardClearTimeResource::collection($data['topUsers']),
                    'currentUser' => $data['currentUser'] ?
                        new LeaderboardClearTimeResource($data['currentUser']) : null,
                ];

            case 'point':
                $data = $this->leaderboardService->getFromPoint($userId);
                return [
                    'topUsers' => LeaderboardPointResource::collection($data['topUsers']),
                    'currentUser' => $data['currentUser'] ?
                        new LeaderboardPointResource($data['currentUser']) : null,
                ];

            case 'crossword':
                // Not yet done
                $data = $this->leaderboardService->getFromCrossword($userId);
                return [
                    'topUsers' => LeaderboardCrosswordResource::collection($data['topUsers']),
                    'currentUser' => $data['currentUser'] ?
                        new LeaderboardCrosswordResource($data['currentUser']) : null,
                ];

            default:
                throw new \InvalidArgumentException('Invalid leaderboard type');
        }
    }
}
