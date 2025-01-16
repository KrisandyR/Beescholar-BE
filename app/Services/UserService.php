<?php

namespace App\Services;

use App\Http\Resources\Scene\DialogueResource;
use App\Http\Resources\Scene\EventResource;
use App\Http\Resources\Scene\MinigameResource;
use App\Models\ActivityProgress;
use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Dialogue;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\MinigameAttempt;
use App\Models\QuestProgress;
use App\Models\Scene;
use App\Models\User;
use App\Models\UserPointProgress;
use Illuminate\Validation\ValidationException;

class UserService {

    public function updateUserTotalPoint($userId, $pointGained){
        $user = User::findOrFail($userId);
        $user->addPoints($pointGained);
    }

    public function getUser($userId){
        return User::find($userId);
    }

    public function resetUser($userId) {
        // Find the user by ID
        $user = User::find($userId);

        // Reset user's points and completion date
        $user->total_point = 0;
        $user->completion_date = null;

        // Delete all UserPointProgress records for the user
        UserPointProgress::where('user_id', $userId)->delete();

        // Delete all MinigameAttempt records for the user
        MinigameAttempt::where('user_id', $userId)->delete();

        // Reset ActivityProgress for the user
        ActivityProgress::where('user_id', $userId)->update([
            'status' => 'Incomplete',
            'is_completed' => false, // default false
            'completion_date' => null, // nullable
            'last_scene_id' => null, // nullable
        ]);

        ActivityProgress::where('user_id', $userId)
            ->whereNot('created_by', 'ActivityProgressTableSeeder')
            ->delete();

        // Reset QuestProgress for the user
        QuestProgress::where('user_id', $userId)->update([
            'status' => 'Incomplete',
            'is_completed' => false, // Default false
            'completion_date' => null, // Nullable
        ]);

        QuestProgress::where('user_id', $userId)
            ->whereNot('created_by', 'QuestProgressTableSeeder')
            ->delete();


        $kmgCampusId = Campus::where('campus_name', 'Kemanggisan')->first()
            ->id;
        // Kemanggisan Campus
        CampusProgress::where('user_id', $userId)
            ->whereNot('campus_id', $kmgCampusId)
            ->update([
            'is_locked' => true, // Default true
            'is_story_locked' => true, // Default true
            'is_semester_locked' => false,
        ]);

        CampusProgress::where('user_id', $userId)
            ->whereNot('created_by', 'CampusProgressTableSeeder')
            ->delete();

        // Save the updated user
        $user->save();
    }
}
