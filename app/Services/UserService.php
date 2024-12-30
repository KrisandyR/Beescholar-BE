<?php

namespace App\Services;

use App\Http\Resources\Scene\DialogueResource;
use App\Http\Resources\Scene\EventResource;
use App\Http\Resources\Scene\MinigameResource;
use App\Models\Dialogue;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\Scene;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserService {

    public function updateUserTotalPoint($userId, $pointGained){
        $user = User::findOrFail($userId);
        $user->addPoints($pointGained);
    }

    public function getUser($userId){
        return User::find($userId);
    }
}
