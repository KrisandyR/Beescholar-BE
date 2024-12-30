<?php

namespace App\Http\Controllers;

use App\Services\MinigameService;


class MinigameController extends Controller
{
    protected $minigameService;

    public function __construct(MinigameService $minigameService)
    {
        $this->minigameService = $minigameService;
    }
    public function getMinigame(string $minigameId)
    {
        try{
            if(!$this->minigameService->findMinigame($minigameId)){
                return response()->json([
                    'success' => false,
                    'message' => 'Minigame not found',
                ], 404);
            }

            $data = $this->minigameService->getMinigame($minigameId);

            return response()->json([
                'success' => true,
                'message' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }
}
