<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }
    //
    public function getRoomFromCampus(string $campusId){
        try {
            $data = $this->roomService->getRoom($campusId);

            if ($data->isEmpty()){
                return response()->json([
                    'success' => false,
                    'message' => 'Rooms not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => RoomResource::collection($data)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }
}
