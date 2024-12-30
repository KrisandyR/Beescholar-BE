<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CampusService
{
    public function getUnlockedCampus(string $userId)
    {
        $user = User::find($userId);

        if (!$user){
            return new Collection();
        }

        $unlocked_campus_ids = CampusProgress::where('user_id', $userId)
            ->where('is_locked', false)
            ->get()->pluck('campus_id');

        if ($unlocked_campus_ids->isEmpty()){
            // Unlock Kemanggisan Campus if no unlocked campus
            $kemanggisan_campus_id = Campus::where('campus_name', 'Kemanggisan')->first()->id;
            CampusProgress::create([
                'user_id' => $userId,
                'campus_id' => $kemanggisan_campus_id,
                'is_locked' => false, // Default true
                'is_story_locked' => false,
                'is_semester_locked' => false,
                'created_by' => 'GetUnlockedCampus',
                'updated_by' => null,
            ]);

            $unlocked_campus_ids->push($kemanggisan_campus_id);
        }
        
        return Campus::whereIn('id', $unlocked_campus_ids)->get();
    }
}
