<?php

namespace App\Services;

use App\Http\Resources\Scene\DialogueResource;
use App\Http\Resources\Scene\EventResource;
use App\Http\Resources\Scene\MinigameResource;
use App\Models\Dialogue;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\Room;
use App\Models\Scene;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RoomService {

    public function getRoom($campusId){
        return Room::where('campus_id', $campusId)->get();
    }
}
