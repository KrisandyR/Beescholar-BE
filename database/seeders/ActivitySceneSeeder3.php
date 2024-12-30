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

class ActivitySceneSeeder3 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $quests = Quest::all();


        foreach ($quests as $quest) {
            $first_activity = Activity::where('quest_id', $quest->id)
                ->where('activity_name', 'Life at School')
                ->first();
        
            if ($first_activity) {
                echo "Found activity: " . $first_activity->activity_name . " for quest " . $quest->id . "\n";
                $this->createClassroomDialogueFlow($first_activity->id);
            } else {
                echo "No 'Life at School' activity found for quest " . $quest->id . "\n";
            }
        }
        
    }

    public function createClassroomDialogueFlow(string $activityId)
    {
        $ricoCharacterId = Character::where('character_name', 'Rico')->first()->id;
        $dianaCharacterId = Character::where('character_name', 'Diana')->first()->id;
        $aniaCharacterId = Character::where('character_name', 'Ania')->first()->id;
        $eniaCharacterId = Character::where('character_name', 'Enia')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        // Scene 1: Initial Greeting
        $scene1 = $this->createScene($activityId, 'classroom.jpg', true, false);
        $dialogue1 = $this->createDialogue('Hey, it’s the new Beescholar! Welcome to the classroom of dreams and… questionable noise levels.', $ricoCharacterId);
        $scene1->sceneable()->associate($dialogue1);
        $scene1->save();

        // Scene 2: Diana’s Introduction
        $scene2 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue2 = $this->createDialogue('Rico, not everyone dreams of headaches. I’m Diana, singer of the band club. Nice to meet you.', $dianaCharacterId);
        $scene2->sceneable()->associate($dialogue2);
        $scene2->save();

        // Scene 3: MC Greets Ania and Enia
        $scene3 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue3 = $this->createDialogue('Nice to meet you both. And you two by the window?', $mcCharacterId);
        $scene3->sceneable()->associate($dialogue3);
        $scene3->save();

        // Scene 4: Ania Introduces Herself
        $scene4 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue4 = $this->createDialogue('I’m Ania. I write poetry, mostly about love and the weather. You’ll catch me staring out the window a lot.', $aniaCharacterId);
        $scene4->sceneable()->associate($dialogue4);
        $scene4->save();

        // Scene 5: Enia Introduces Herself
        $scene5 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue5 = $this->createDialogue('I’m Enia. I sketch stars and flowers… though Rico’s drumming makes them look like earthquakes.', $eniaCharacterId);
        $scene5->sceneable()->associate($dialogue5);
        $scene5->save();

        // Scene 6: Rico Reacts
        $scene6 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue6 = $this->createDialogue('That’s artistic flair, thank you very much.', $ricoCharacterId);
        $scene6->sceneable()->associate($dialogue6);
        $scene6->save();

        // Scene 7: MC Comments
        $scene7 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue7 = $this->createDialogue('This place definitely has personality.', $mcCharacterId);
        $scene7->sceneable()->associate($dialogue7);
        $scene7->save();

        // Scene 8: Diana's Observation
        $scene8 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue8 = $this->createDialogue('Personality is one way to put it. Chaos is another.', $dianaCharacterId);
        $scene8->sceneable()->associate($dialogue8);
        $scene8->save();

        // Scene 9: Ania Adds Insight
        $scene9 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue9 = $this->createDialogue('But the fun kind of chaos. Beescholar life is about finding your own rhythm—even if it’s drowned out by Rico.', $aniaCharacterId);
        $scene9->sceneable()->associate($dialogue9);
        $scene9->save();

        // Scene 10: Enia’s Humor
        $scene10 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue10 = $this->createDialogue('Or if your art gets turned into abstract sketches.', $eniaCharacterId);
        $scene10->sceneable()->associate($dialogue10);
        $scene10->save();

        // Branching Option: MC’s Response to Rico
        $scene11 = $this->createScene($activityId, 'classroom.jpg');
        $dialogue11 = $this->createDialogue('Sounds like I’m in the right place. Thanks for the welcome.', $mcCharacterId);
        $dialogue_option_11a = $this->createDialogueOption($dialogue11->id, 'I’m excited to join the chaos!');
        $dialogue_option_11b = $this->createDialogueOption($dialogue11->id, 'I’ll try to survive the noise.');

        $scene11->sceneable()->associate($dialogue11);
        $scene11->save();

        // Branch 1: Excited Response
        $scene11a = $this->createScene($activityId, 'classroom.jpg');
        $dialogue11a = $this->createDialogue('I’m excited to join the chaos!', $mcCharacterId);
        $scene11a->sceneable()->associate($dialogue11a);
        $scene11a->save();

        $scene12a = $this->createScene($activityId, 'classroom.jpg', false, true);
        $dialogue12a = $this->createDialogue('That’s the spirit! You’ll fit right in.', $dianaCharacterId);
        $scene12a->sceneable()->associate($dialogue12a);
        $scene12a->save();

        // Branch 2: Hesitant Response
        $scene11b = $this->createScene($activityId, 'classroom.jpg');
        $dialogue11b = $this->createDialogue('I’ll try to survive the noise.', $mcCharacterId);
        $scene11b->sceneable()->associate($dialogue11b);
        $scene11b->save();

        $scene12b = $this->createScene($activityId, 'classroom.jpg', false, true);
        $dialogue12b = $this->createDialogue('You’ll get used to it. Just don’t sit too close to Rico.', $aniaCharacterId);
        $scene12b->sceneable()->associate($dialogue12b);
        $scene12b->save();

        // Update Branches
        $dialogue_option_11a->update(['next_scene_id' => $scene11a->id]);
        $dialogue_option_11b->update(['next_scene_id' => $scene11b->id]);

        // Update Main Flow
        $scene1->update(['next_scene_id' => $scene2->id]);
        $scene2->update(['next_scene_id' => $scene3->id]);
        $scene3->update(['next_scene_id' => $scene4->id]);
        $scene4->update(['next_scene_id' => $scene5->id]);
        $scene5->update(['next_scene_id' => $scene6->id]);
        $scene6->update(['next_scene_id' => $scene7->id]);
        $scene7->update(['next_scene_id' => $scene8->id]);
        $scene8->update(['next_scene_id' => $scene9->id]);
        $scene9->update(['next_scene_id' => $scene10->id]);
        $scene10->update(['next_scene_id' => $scene11->id]);
        $scene11a->update(['next_scene_id' => $scene12a->id]);
        $scene11b->update(['next_scene_id' => $scene12b->id]);
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
