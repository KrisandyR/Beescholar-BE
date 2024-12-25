<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Crossword;
use App\Models\CrosswordWord;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\Quest;
use App\Models\Scene;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySceneSeeder6 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $quests = Quest::all();
        $activities = Activity::where('activity_name', 'Try Crossword')->get();

        // Check if any activities were found
        if ($activities->isEmpty()) {
            echo "No 'Try Crossword' activity found.";
        } else {
            foreach ($activities as $activity) {
                echo "Found activity: " . $activity->activity_name . "\n";
                $this->createSceneFlow($activity->id);
            }
        }
        
    }

    public function createSceneFlow(string $activityId)
    {
        // Tutorial Trigger
        $scene1 = $this->createScene($activityId);
        $event1 = Event::create([
            'event_name' => 'Crossword Tutorial',
            'event_type' => 'Tutorial',
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);

        $scene1->sceneable()->associate($event1);
        $scene1->save();

        // Minigame Trigger
        $scene2 = $this->createScene($activityId);
        $minigame2 = $this->createCrosswordMinigame();

        $scene2->sceneable()->associate($minigame2);
        $scene2->save();
    }

    public function createCrosswordMinigame()
    {
        // Create the Crossword Minigame
        $crossword = Crossword::create([
            'theme' => 'Learning Model',
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);

        // Create the Minigame entry for the Crossword
        $minigame = Minigame::create([
            'minigame_name' => 'Academic Activities Crossword',
            'instruction' => 'Solve the crossword by answering the academic activities-related clues!',
            'maximum_point_reward' => 100,
            'minimum_passing_point' => 100,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);

        // Associate the Crossword with the Minigame
        $minigame->minigameable()->associate($crossword);
        $minigame->save();

        // Create Crossword Words
        $crosswordWords = [
            [
                'word_answer' => 'PROJECTOR',
                'clue' => 'Device used to display PPT or non-PPT materials in class.',
                'direction' => 'horizontal',
                'col_start_idx' => 1,
                'row_start_idx' => 2,
            ],
            [
                'word_answer' => 'ZOOM',
                'clue' => 'Platform used for Video Conference (ViCon) classes.',
                'direction' => 'vertical',
                'col_start_idx' => 3,
                'row_start_idx' => 1,
            ],
            [
                'word_answer' => 'GSLC',
                'clue' => 'Learning method where students discuss topics on forums over 7 days.',
                'direction' => 'vertical',
                'col_start_idx' => 3,
                'row_start_idx' => 10,
            ],
            [
                'word_answer' => 'ATTENDANCE',
                'clue' => 'Required for Face to Face (F2F) classes to confirm student presence.',
                'direction' => 'vertical',
                'col_start_idx' => 7,
                'row_start_idx' => 1,
            ],
            [
                'word_answer' => 'COURSE',
                'clue' => 'Menu in BINUSMAYA to view class discussions and materials.',
                'direction' => 'vertical',
                'col_start_idx' => 5,
                'row_start_idx' => 8,
            ],
            [
                'word_answer' => 'VICON',
                'clue' => 'Abbreviation for Video Conference used in online learning.',
                'direction' => 'horizontal',
                'col_start_idx' => 3,
                'row_start_idx' => 8,
            ],
            [
                'word_answer' => 'SCHEDULE',
                'clue' => 'Menu to check class timings and session details.',
                'direction' => 'horizontal',
                'col_start_idx' => 2,
                'row_start_idx' => 13,
            ],
        ];

        foreach ($crosswordWords as $word) {
            CrosswordWord::create([
                'word_answer' => $word['word_answer'],
                'clue' => $word['clue'],
                'direction' => $word['direction'],
                'col_start_idx' => $word['col_start_idx'],
                'row_start_idx' => $word['row_start_idx'],
                'crossword_id' => $crossword->id,
                'created_by' => 'SceneDialogueSeeder',
                'updated_by' => null,
            ]);
        }

        return $minigame;
    }

    public function createScene(string $activityId, string $background = null, bool $start = false, bool $end = false){
        return Scene::create([
            'background' => $background,
            'is_start_scene' => $start,
            'is_end_scene' => $end,
            'activity_id' => $activityId, // Replace with actual Activity ID
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);
    }
}
