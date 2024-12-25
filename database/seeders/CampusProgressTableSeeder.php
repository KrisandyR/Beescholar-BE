<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampusProgressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $campuses = Campus::all();

        $this->command->info($users->count());
        $this->command->info($campuses->count());


        if ($users->isEmpty() || $campuses->isEmpty()) {
            $this->command->warn('No users or campuses found. Skipping CampusProgress seeding.');
            return;
        }

        foreach($users as $user){
            $user_id = $user->id;

            foreach($campuses as $campus){
                $campus_id = $campus->id;
                $is_locked = $campus->campus_name !== 'Kemanggisan';
                $is_story_locked = $campus->campus_name !== 'Kemanggisan';

                CampusProgress::create([
                    'user_id' => $user_id,
                    'campus_id' => $campus_id,
                    'is_locked' => $is_locked, // Default true
                    'is_story_locked' => $is_story_locked, // Default true
                    'is_semester_locked' => false,
                    'created_by' => 'CampusProgressTableSeeder',
                    'updated_by' => null,
                ]);
            }
        }
    }
}
