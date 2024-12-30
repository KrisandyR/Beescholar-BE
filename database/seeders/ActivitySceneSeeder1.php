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

class ActivitySceneSeeder1 extends Seeder
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
                ->where('activity_name', 'Introduction')
                ->first();
        
            if ($first_activity) {
                echo "Found activity: " . $first_activity->activity_name . " for quest " . $quest->id . "\n";
                $this->createDialogueFlow($first_activity->id);
            } else {
                echo "No 'Introduction' activity found for quest " . $quest->id . "\n";
            }
        }

    }

    public function createDialogueFlow(string $activityId)
    {
        $diyanCharacterId = Character::where('character_name', 'Diyan')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        // 1
        $scene1 = $this->createScene($activityId, 'teachers_office.jpg', true, false);
        $dialogue1 = $this->createDialogue('Welcome, [MC]. Please, have a seat. I have some exciting news for you.',
            $diyanCharacterId);

        $scene1->sceneable()->associate($dialogue1);
        $scene1->save();

        // 2
        $scene2 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue2 = $this->createDialogue('Exciting news? What is it, Mr. Diyan?',
            $mcCharacterId);

        $scene2->sceneable()->associate($dialogue2);
        $scene2->save();

        // 3
        $scene3 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue3 = $this->createDialogue('After reviewing your performance and observing your potential, I am delighted to inform you that you’ve officially been accepted as a member of the Beescholar organization!',
            $diyanCharacterId);

        $scene3->sceneable()->associate($dialogue3);
        $scene3->save();

        // 4
        $scene4 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue4 = $this->createDialogue('Really? That’s amazing! I’m so grateful for this opportunity.',
            $mcCharacterId);

        $scene4->sceneable()->associate($dialogue4);
        $scene4->save();

        // 5
        $scene5 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue5 = $this->createDialogue('Of course. Beescholar plays a vital role in this campus. You’ll not only learn valuable skills but also contribute to making this community a better place.',
            $diyanCharacterId);

        $scene5->sceneable()->associate($dialogue5);
        $scene5->save();

        // 6
        $scene6 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue6 = $this->createDialogue('Here, I also have something for you. This poster explains the steps and process of becoming a Beescholar. Keep it safe—it will help you understand your role better.',
            $diyanCharacterId);

        $scene6->sceneable()->associate($dialogue6);
        $scene6->save();

        // 7
        $scene7 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue7 = $this->createDialogue('Thank you, Mr. Diyan. I’ll make sure to read it carefully and prepare myself.',
            $mcCharacterId);

        $scene7->sceneable()->associate($dialogue7);
        $scene7->save();

        // 8
        $scene8 = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue8 = $this->createDialogue('Good. This poster will also be saved in your tutorial icon, so you can access it anytime. From today onwards, your journey as a Beescholar begins. Make sure to tackle each stage with enthusiasm.',
            $diyanCharacterId);
        $dialogue_option_8a = $this->createDialogueOption($dialogue8->id, 'I will! I’ll do my very best.');
        $dialogue_option_8b = $this->createDialogueOption($dialogue8->id, 'No worries! I’ll handle it.');
        $dialogue_option_8c = $this->createDialogueOption($dialogue8->id, 'You can count on me! I’ll do my best.');

        $scene8->sceneable()->associate($dialogue8);
        $scene8->save();

        //8a
        $scene8a = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue8a = $this->createDialogue('I will! I’ll do my very best.',
            $mcCharacterId);

        $scene8a->sceneable()->associate($dialogue8a);
        $scene8a->save();

        //8b
        $scene8b = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue8b = $this->createDialogue('No worries! I’ll handle it.',
            $mcCharacterId);

        $scene8b->sceneable()->associate($dialogue8b);
        $scene8b->save();

        //8c
        $scene8c = $this->createScene($activityId, 'teachers_office.jpg');
        $dialogue8c = $this->createDialogue('You can count on me! I’ll do my best.',
            $mcCharacterId);

        $scene8c->sceneable()->associate($dialogue8c);
        $scene8c->save();

        //9a
        $scene9a = $this->createScene($activityId, 'teachers_office.jpg', false, true);
        $dialogue9a = $this->createDialogue('Good! I know you’ll do great.',
            $diyanCharacterId);

        $scene9a->sceneable()->associate($dialogue9a);
        $scene9a->save();

        //9b
        $scene9b = $this->createScene($activityId, 'teachers_office.jpg', false, true);
        $dialogue9b = $this->createDialogue('That’s the attitude I like to see!',
            $diyanCharacterId);

        $scene9b->sceneable()->associate($dialogue9b);
        $scene9b->save();

        //9c
        $scene9c = $this->createScene($activityId, 'teachers_office.jpg', false, true);
        $dialogue9c = $this->createDialogue('I trust you. Let’s make it happen!',
            $diyanCharacterId);

        $scene9c->sceneable()->associate($dialogue9c);
        $scene9c->save();

        $scene1->update([
            'next_scene_id' => $scene2->id
        ]);

        $scene2->update([
            'next_scene_id' => $scene3->id
        ]);

        $scene3->update([
            'next_scene_id' => $scene4->id
        ]);

        $scene4->update([
            'next_scene_id' => $scene5->id
        ]);

        $scene5->update([
            'next_scene_id' => $scene6->id
        ]);

        $scene6->update([
            'next_scene_id' => $scene7->id
        ]);

        $scene7->update([
            'next_scene_id' => $scene8->id
        ]);

        $dialogue_option_8a->update([
            'next_scene_id' => $scene8a->id
        ]);

        $dialogue_option_8b->update([
            'next_scene_id' => $scene8b->id
        ]);

        $dialogue_option_8c->update([
            'next_scene_id' => $scene8c->id
        ]);

        $scene8a->update([
            'next_scene_id' => $scene9a->id
        ]);

        $scene8b->update([
            'next_scene_id' => $scene9b->id
        ]);

        $scene8c->update([
            'next_scene_id' => $scene9c->id
        ]);
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
