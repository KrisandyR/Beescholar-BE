<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Character;
use App\Models\Dialogue;
use App\Models\DialogueOption;
use App\Models\DrumPuzzle;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\Quest;
use App\Models\Scene;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySceneSeeder4 extends Seeder
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
                ->where('activity_name', 'Drum Practice')
                ->first();
        
            if ($first_activity) {
                echo "Found activity: " . $first_activity->activity_name . " for quest " . $quest->id . "\n";
                $this->createDialogueFlow($first_activity->id);
            } else {
                echo "No 'Drum Practice' activity found for quest " . $quest->id . "\n";
            }
        }
        
    }

    public function createDialogueFlow(string $activityId)
    {
        $ehanCharacterId = Character::where('character_name', 'Ehan')->first()->id;
        $dianaCharacterId = Character::where('character_name', 'Diana')->first()->id;
        $ricoCharacterId = Character::where('character_name', 'Rico')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        // Scene 1: Initial Greeting
        $scene1 = $this->createScene($activityId, '/backgrounds/Band-Room.png', true, false);
        $dialogue1 = $this->createDialogue('Yo, [MC]! Just the person I wanted to see. Heard the big news—Beescholar, huh? That’s awesome!', $ehanCharacterId);
        $scene1->sceneable()->associate($dialogue1);
        $scene1->save();

        // Scene 2: Problem Announcement
        $scene2 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue2 = $this->createDialogue('Guys, we have a problem. Rico’s out sick! And today’s the recording session for our band project!', $dianaCharacterId);
        $scene2->sceneable()->associate($dialogue2);
        $scene2->save();

        // Scene 3: Ehan Reacts
        $scene3 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue3 = $this->createDialogue('Oh no, this isn’t good. The club’s counting on us to finish the track. Without Rico… we’re toast.', $ehanCharacterId);
        $scene3->sceneable()->associate($dialogue3);
        $scene3->save();

        // Scene 4: Diana Suggests MC Steps In
        $scene4 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue4 = $this->createDialogue('Wait a second… [MC], you’ve got rhythm, right? You could step in!', $dianaCharacterId);
        $scene4->sceneable()->associate($dialogue4);
        $scene4->save();

        // Scene 5: Player Response Options (Branching)
        $scene5 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue5 = $this->createDialogue('What do you say, [MC]? Can you help us out?', $dianaCharacterId);
        $dialogue_option_5a = $this->createDialogueOption($dialogue5->id, 'Alright, I’ll give it a try.');
        $dialogue_option_5b = $this->createDialogueOption($dialogue5->id, 'I don’t know… I might mess it up.');
        $scene5->sceneable()->associate($dialogue5);
        $scene5->save();

        // Branch 1: Player Agrees to Help
        $scene5a = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue5a = $this->createDialogue('Alright, I’ll give it a try.', $mcCharacterId);
        $scene5a->sceneable()->associate($dialogue5a);
        $scene5a->save();

        $scene6a = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue6a = $this->createDialogue('That’s the spirit! Don’t worry, we’ll guide you through it.', $ehanCharacterId);
        $scene6a->sceneable()->associate($dialogue6a);
        $scene6a->save();

        // Branch 2: Player Hesitates
        $scene5b = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue5b = $this->createDialogue('I don’t know… I might mess it up.', $mcCharacterId);
        $scene5b->sceneable()->associate($dialogue5b);
        $scene5b->save();

        $scene6b = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue6b = $this->createDialogue('Come on, [MC]. You can do this! We’ll keep it simple, I promise.', $dianaCharacterId);
        $scene6b->sceneable()->associate($dialogue6b);
        $scene6b->save();

        // Merge Back to Main Dialogue
        $scene7 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue7 = $this->createDialogue('Let’s get you started with "Follow the Drum." It’s a simple tutorial to get you into the groove.', $ehanCharacterId);
        $scene7->sceneable()->associate($dialogue7);
        $scene7->save();

        $scene8 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue8 = $this->createDialogue('Alright, here we go. Just follow the beat and keep it steady!', $dianaCharacterId);
        $scene8->sceneable()->associate($dialogue8);
        $scene8->save();

        // Tutorial Trigger
        $scene9 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $event9 = Event::create([
            'event_name' => 'Drum Puzzle Tutorial',
            'event_type' => 'Tutorial',
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);

        $scene9->sceneable()->associate($event9);
        $scene9->save();

        // Minigame Trigger
        $scene10 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $minigame10 = $this->createDrumPuzzleMinigame();

        $scene10->sceneable()->associate($minigame10);
        $scene10->save();

        // Scene 11: Ehan’s Encouragement
        $scene11 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue11 = $this->createDialogue('See? That wasn’t so bad! You’ve got a knack for this, [MC].', $ehanCharacterId);
        $scene11->sceneable()->associate($dialogue11);
        $scene11->save();

        // Scene 12: Diana’s Praise
        $scene12 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue12 = $this->createDialogue('You nailed it! I knew you could do it. Now we’re ready to record.', $dianaCharacterId);
        $scene12->sceneable()->associate($dialogue12);
        $scene12->save();

        // Scene 13: MC’s Humble Response
        $scene13 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue13 = $this->createDialogue('Let’s just hope I don’t mess up the real thing.', $mcCharacterId);
        $scene13->sceneable()->associate($dialogue13);
        $scene13->save();

        // Scene 14: Ehan’s Playful Remark
        $scene14 = $this->createScene($activityId, '/backgrounds/Band-Room.png');
        $dialogue14 = $this->createDialogue('Don’t worry, we’ll keep the bloopers for the band’s highlight reel.', $ehanCharacterId);
        $scene14->sceneable()->associate($dialogue14);
        $scene14->save();

        // Scene 15: Diana’s Excited Wrap-Up
        $scene15 = $this->createScene($activityId, '/backgrounds/Band-Room.png', false, true);
        $dialogue15 = $this->createDialogue('Alright, let’s do this. To the studio!', $dianaCharacterId);
        $scene15->sceneable()->associate($dialogue15);
        $scene15->save();

        // Update Branches
        $dialogue_option_5a->update(['next_scene_id' => $scene5a->id]);
        $dialogue_option_5b->update(['next_scene_id' => $scene5b->id]);
        $scene5a->update(['next_scene_id' => $scene6a->id]);
        $scene5b->update(['next_scene_id' => $scene6b->id]);
        $scene6a->update(['next_scene_id' => $scene7->id]);
        $scene6b->update(['next_scene_id' => $scene7->id]);

        // Update Main Dialogue Flow
        $scene1->update(['next_scene_id' => $scene2->id]);
        $scene2->update(['next_scene_id' => $scene3->id]);
        $scene3->update(['next_scene_id' => $scene4->id]);
        $scene4->update(['next_scene_id' => $scene5->id]);
        $scene7->update(['next_scene_id' => $scene8->id]);
        $scene8->update(['next_scene_id' => $scene9->id]);
        $scene9->update(['next_scene_id' => $scene10->id]);
        $scene10->update(['next_scene_id' => $scene11->id]);
        $scene11->update(['next_scene_id' => $scene12->id]);
        $scene12->update(['next_scene_id' => $scene13->id]);
        $scene13->update(['next_scene_id' => $scene14->id]);
        $scene14->update(['next_scene_id' => $scene15->id]);
    }

    public function createDrumPuzzleMinigame()
    {
        // Create the DrumPuzzle
        $drumPuzzle = DrumPuzzle::create([
            'total_hit' => 5,
        ]);

        // Create the Minigame and associate it with the DrumPuzzle
        $minigame = Minigame::create([
            'minigame_name' => 'Drum Puzzle Challenge',
            'instruction' => 'Follow the drum pattern 5 times to solve the puzzle.',
            'maximum_point_reward' => 100,
            'minimum_passing_point' => 0,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);

        $minigame->minigameable()->associate($drumPuzzle);
        $minigame->save();

        return $minigame;
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