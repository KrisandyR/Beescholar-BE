<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Campus;
use App\Models\Quest;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate Quests and Quests Activity
        $as_campus = Campus::where('campus_name', 'Alam Sutera')->first();

        $quest1 = Quest::create([
            'title' => 'Welcome to the Campus',
            'description' => 'Help the campus orientation committee set up welcome booths for new students.',
            'unlock_campus_id' => $as_campus->id,
            'unlock_quest_id' => null,
            'unlock_activity_id' => null,
            'completion_point' => 100,
            'date_start' => null,
            'date_end' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $quest2  = Quest::create([
            'title' => 'Library Mystery',
            'description' => 'Assist the librarian in organizing the archive section and solving the missing book mystery.',
            'unlock_campus_id' => null,
            'unlock_quest_id' => null,
            'unlock_activity_id' => null,
            'completion_point' => 1500,
            'date_start' => null,
            'date_end' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $quest3 = Quest::create([
            'title' => 'Sports Festival Prep',
            'description' => 'Help the student council prepare for the upcoming sports festival by organizing the schedule.',
            'unlock_campus_id' => null,
            'unlock_quest_id' => null,
            'unlock_activity_id' => null,
            'completion_point' => 400,
            'date_start' => null,
            'date_end' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $quest4 = Quest::create([
            'title' => 'Campus Clean-Up',
            'description' => 'Participate in the campus clean-up drive to promote environmental awareness.',
            'unlock_campus_id' => null,
            'unlock_quest_id' => null,
            'unlock_activity_id' => null,
            'completion_point' => 200,
            'date_start' => null,
            'date_end' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $quest5 = Quest::create([
            'title' => 'Tech Support Trouble',
            'description' => 'Assist the IT department in resolving network issues affecting students during exams.',
            'unlock_campus_id' => null,
            'unlock_quest_id' => null,
            'unlock_activity_id' => null,
            'completion_point' => 500,
            'date_start' => null,
            'date_end' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $this->logToConsole($quest2->id);

        $quest1_start_activity_id = $this->questActivity($quest1->id);
        $quest1->update([
            'unlock_activity_id' => $quest1_start_activity_id,
            'unlock_quest_id' => $quest2->id, // Replace with the ID of the quest to unlock
        ]);

        $quest2_start_activity_id = $this->questActivity($quest2->id);
        $quest2->update([
            'unlock_activity_id' => $quest2_start_activity_id,
            'unlock_quest_id' => $quest3->id, // Replace with the ID of the quest to unlock
        ]);
    

        $quest3_start_activity_id = $this->questActivity($quest3->id);
        $quest3->update([
            'unlock_activity_id' => $quest3_start_activity_id,
            'unlock_quest_id' => $quest4->id, // Replace with the ID of the quest to unlock
        ]);

        $quest4_start_activity_id = $this->questActivity($quest4->id);
        $quest4->update([
            'unlock_activity_id' => $quest4_start_activity_id,
            'unlock_quest_id' => $quest5->id, // Replace with the ID of the quest to unlock
        ]);

    }

    public function questActivity(string $questId){

        $campus = Campus::where('campus_name', 'Kemanggisan')->first();
        $classroom_id = $campus->rooms()->where('room_name', 'Classroom')->first()->id;
        $bandroom_id = $campus->rooms()->where('room_name', 'Band Room')->first()->id;
        $teacher_office_id = $campus->rooms()->where('room_name', 'Teacher Office')->first()->id;
        $hallway_id = $campus->rooms()->where('room_name', 'Hallway')->first()->id;
        $this->logToConsole("questActivity function");
        $this->logToConsole($questId);

        $activity1 = Activity::create([
            'activity_name' => 'Introduction',
            'type' => 'Story Quest',
            'description' => 'Introduces yourself in this new campus!',
            'is_repeatable' => false,
            'completion_point' => 50,
            'priority' => 1,
            'quest_id' => $questId,
            'room_id' => $teacher_office_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity2 = Activity::create([
            'activity_name' => 'Helping Hands',
            'type' => 'Story Quest',
            'description' => 'Listen to the students story and help them navigate through their problems.',
            'is_repeatable' => false,
            'completion_point' => 50,
            'priority' => 1,
            'quest_id' => $questId,
            'room_id' => $hallway_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity3 = Activity::create([
            'activity_name' => 'Life at School',
            'type' => 'Story Quest',
            'description' => 'Enjoy the daily life at school',
            'is_repeatable' => false,
            'completion_point' => 50,
            'priority' => 1,
            'quest_id' => $questId,
            'room_id' => $classroom_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity4 = Activity::create([
            'activity_name' => 'Drum Practice',
            'type' => 'Story Quest',
            'description' => 'Practice the drums in the drum room.',
            'is_repeatable' => false,
            'completion_point' => 50,
            'priority' => 1,
            'quest_id' => $questId,
            'room_id' => $bandroom_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity5 = Activity::create([
            'activity_name' => 'Stage',
            'type' => 'Story Quest',
            'description' => 'Prove yourself worthy to complete your journey on Kemanggisan Campus',
            'is_repeatable' => false,
            'completion_point' => 100,
            'priority' => 1,
            'quest_id' => $questId,
            'room_id' => $classroom_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity6 = Activity::create([
            'activity_name' => 'Try Crossword',
            'type' => 'Trivial Task',
            'description' => 'Extra homework you can do',
            'is_repeatable' => false,
            'completion_point' => 100,
            'priority' => 1,
            'quest_id' => null,
            'room_id' => $hallway_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity7 = Activity::create([
            'activity_name' => 'Wise Words',
            'type' => 'Trivial Task',
            'description' => 'Diyan wants to talk to you',
            'is_repeatable' => false,
            'completion_point' => 50,
            'priority' => 1,
            'quest_id' => null,
            'room_id' => $teacher_office_id,
            'unlock_activity_id' => null,
            'created_by' => 'QuestActivityTableSeeder',
            'updated_by' => null,
        ]);

        $activity1->update([
            'unlock_activity_id' => $activity2->id
        ]);

        $activity2->update([
            'unlock_activity_id' => $activity3->id
        ]);

        $activity3->update([
            'unlock_activity_id' => $activity4->id
        ]);

        $activity4->update([
            'unlock_activity_id' => $activity5->id
        ]);

        $activity5->update([
            'unlock_activity_id' => $activity6->id
        ]);

        $activity6->update([
            'unlock_activity_id' => $activity7->id
        ]);

        return $activity1->id;
    }
    
    private function logToConsole($message)
    {
        if (app()->runningInConsole()) {
            $this->command->info($message);
        }
    }

}
