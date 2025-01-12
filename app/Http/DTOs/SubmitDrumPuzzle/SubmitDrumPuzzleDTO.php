<?php

namespace App\Http\DTOs\SubmitDrumPuzzle;

use Illuminate\Http\Request;

class SubmitDrumPuzzleDTO
{
    public string $minigameId;
    public int $point;
    public object $patternAnswer; // Define as object to hold JSON data

    public function __construct(Request $request)
    {
        // Validate and extract data from the request
        $validatedData = $request->validate([
            'minigameId' => 'required|uuid',
            'point' => 'required|integer',
            'patternAnswer' => 'required|json', // Validate as a JSON string
        ]);

        $this->minigameId = $validatedData['minigameId'];
        $this->point = $validatedData['point'];
        $this->patternAnswer = json_decode($validatedData['patternAnswer']); // Decode JSON string into an object
    }
}
