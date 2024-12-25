<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityProgress;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityProgressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();

        foreach($users as $user){

            $first_quest_id = Quest::where('title', 'Welcome to the Campus')->first()->id;
            $first_activity_id = Activity::where('quest_id', $first_quest_id)->first()->id;

            ActivityProgress::create([
                'status' => 'Incomplete',
                'is_completed' => false, // default false
                'completion_date' => null, // nullable
                'activity_id' => $first_activity_id,
                'user_id' => $user->id,
                'last_scene_id' => null, // nullable
                'created_by' => 'ActivityProgressTableSeeder',
                'updated_by' => null,
            ]);
        }
    }
}
