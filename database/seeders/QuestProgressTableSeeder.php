<?php

namespace Database\Seeders;

use App\Models\Quest;
use App\Models\QuestProgress;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestProgressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();

        foreach($users as $user){

            $first_quest = Quest::where('title', 'Welcome to the Campus')->first();

            QuestProgress::create([
                'status' => 'Incomplete',
                'is_completed' => false, // Default false
                'completion_date' => null, // Nullable
                'quest_id' => $first_quest->id,
                'user_id' => $user->id,
                'created_by' => 'QuestProgressTableSeeder',
                'updated_by' => null,
            ]);
        }
    }
}
