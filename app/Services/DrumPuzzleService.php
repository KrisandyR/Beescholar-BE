<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\DrumPuzzle;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class DrumPuzzleService
{
    public function getDrumPuzzleMinigame($minigameableId){
        return DrumPuzzle::findOrFail($minigameableId);
    }
}
