<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Character;
use App\Models\Dialogue;
use App\Models\DialogueOption;
use App\Models\Quest;
use App\Models\Scene;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySceneSeeder7 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $activities = Activity::where('activity_name', 'Wise Words')->get();

        // Check if any activities were found
        if ($activities->isEmpty()) {
            echo "No 'Wise Words' activity found.";
        } else {
            foreach ($activities as $activity) {
                echo "Found activity: " . $activity->activity_name . "\n";
                $this->createClassroomDialogueFlow($activity->id);
            }
        }
    }

    public function createClassroomDialogueFlow(string $activityId)
    {
        $diyanCharacterId = Character::where('character_name', 'Diyan')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        // Scene 1: It was great meeting everyone
        $scene1 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue1 = $this->createDialogue('It was great meeting everyone. I’m looking forward to this journey.', $mcCharacterId);
        $scene1->sceneable()->associate($dialogue1);
        $scene1->save();

        // Scene 2: Same here! Amazing memories ahead
        $scene2 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue2 = $this->createDialogue('Same here! I think we’re going to make some amazing memories together.', $diyanCharacterId);
        $scene2->sceneable()->associate($dialogue2);
        $scene2->save();

        // Scene 3: Let’s make the most of our time
        $scene3 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue3 = $this->createDialogue('Let’s make the most of our time and help each other along the way.', $mcCharacterId);
        $scene3->sceneable()->associate($dialogue3);
        $scene3->save();

        // Scene 4: Can’t wait to see what we can achieve
        $scene4 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue4 = $this->createDialogue('Absolutely! I can’t wait to see what we can achieve together.', $diyanCharacterId);
        $scene4->sceneable()->associate($dialogue4);
        $scene4->save();

        // Scene 5: Here’s to new beginnings
        $scene5 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue5 = $this->createDialogue('Here’s to new beginnings and an exciting journey ahead!', $mcCharacterId);
        $scene5->sceneable()->associate($dialogue5);
        $scene5->save();

        // Update Main Flow
        $scene1->update(['next_scene_id' => $scene2->id]);
        $scene2->update(['next_scene_id' => $scene3->id]);
        $scene3->update(['next_scene_id' => $scene4->id]);
        $scene4->update(['next_scene_id' => $scene5->id]);
    }

    public function createScene(string $activityId, string $background, bool $start = false, bool $end = false){
        return Scene::create([
            'background' => $background,
            'is_start_scene' => $start,
            'is_end_scene' => $end,
            'activity_id' => $activityId, // Replace with actual Activity ID
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);
    }

    public function createDialogue(string $text, string $characterId = null)
    {
        return Dialogue::create([
            'character_id' => $characterId,
            'dialogue_text' => $text,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);
    }

    public function createDialogueOption(string $dialogueId, string $choiceText)
    {
        return DialogueOption::create([
            'option_text' => $choiceText,
            'dialogue_id' => $dialogueId,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);
    }
}
