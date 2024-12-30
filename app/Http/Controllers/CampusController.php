<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampusResource;
use App\Models\Campus;
use App\Models\CampusProgress;
use App\Services\CampusService;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    protected $campusService;

    public function __construct(CampusService $campusService)
    {
        $this->campusService = $campusService;
    }
    
    public function getUnlockedCampus(string $userId)
    {
        try {
            $data = $this->campusService->getUnlockedCampus($userId);

            if ($data->isEmpty()){
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => CampusResource::collection($data)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }
}
