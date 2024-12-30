<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function getCharactersBasedOnCampus(string $campusName)
    {
        try {
            $characters = Character::whereHas('campus', function ($query) use ($campusName) {
                $query->where('campus_name', $campusName);
            })->get();
    
            if ($characters->isEmpty()){
                return response()->json([
                    'success' => false,
                    'message' => 'No characters found',
                ], 404);
            }
    
            // Return a JSON response
            return response()->json([
                'success' => true,
                'data' => CharacterResource::collection($characters)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }

    }
}
