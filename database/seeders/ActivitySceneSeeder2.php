<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Character;
use App\Models\Dialogue;
use App\Models\DialogueOption;
use App\Models\Minigame;
use App\Models\Quest;
use App\Models\Quiz;
use App\Models\QuizChoice;
use App\Models\QuizQuestion;
use App\Models\Scene;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySceneSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quests = Quest::all();

        foreach ($quests as $quest) {
            $first_activity = Activity::where('quest_id', $quest->id)
                ->where('activity_name', 'Helping Hands')
                ->first();
        
            if ($first_activity) {
                echo "Found activity: " . $first_activity->activity_name . " for quest " . $quest->id . "\n";
                $this->createDialogueFlow($first_activity->id);
            } else {
                echo "No 'Helping Hands' activity found for quest " . $quest->id . "\n";
            }
        }

    }

    public function createDialogueFlow(string $activityId)
    {
        $agungCharacterId = Character::where('character_name', 'Agung')->first()->id;
        $agathaCharacterId = Character::where('character_name', 'Agatha')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        // 1
        $scene1 = $this->createScene($activityId, 'hallway.jpg', true, false);
        $dialogue1 = $this->createDialogue('Ah, you must be the new Beescholar everyone is talking about! Nice to meet you. I’m Agung, the class leader.',
            $agungCharacterId);

        $scene1->sceneable()->associate($dialogue1);
        $scene1->save();

        // 2
        $scene2 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue2 = $this->createDialogue('Nice to meet you, Agung. And you are…?',
            $mcCharacterId);

        $scene2->sceneable()->associate($dialogue2);
        $scene2->save();

        // 3
        $scene3 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue3 = $this->createDialogue('I’m Agatha, leader of the News Club. I couldn’t resist meeting the latest Beescholar candidate. How did Diyan recommend you, if you don’t mind me asking?',
            $agathaCharacterId);

        $scene3->sceneable()->associate($dialogue3);
        $scene3->save();

        // 4
        $scene4 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue4 = $this->createDialogue('Oh, he mentioned something about my determination and potential. It was a bit overwhelming, to be honest.',
            $mcCharacterId);

        $scene4->sceneable()->associate($dialogue4);
        $scene4->save();

        // 5
        $scene5 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue5 = $this->createDialogue('Interesting! You must have made quite an impression. Mind sharing more about your story? It could make an excellent feature in our school’s news board!',
            $agathaCharacterId);

        $scene5->sceneable()->associate($dialogue5);
        $scene5->save();

        // 6
        $scene6 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue6 = $this->createDialogue('Agatha, remember the club rules? The News Club has to stay neutral toward all Beescholar candidates.',
            $agungCharacterId);

        $scene6->sceneable()->associate($dialogue6);
        $scene6->save();

        // 7
        $scene7 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue7 = $this->createDialogue('Ah, you’re right. As much as I’d love to write about you, rules are rules. But that doesn’t mean we can’t be curious. So, how are you finding the campus so far?',
            $agathaCharacterId);

        $scene7->sceneable()->associate($dialogue7);
        $scene7->save();

        // 8
        $scene8 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue8 = $this->createDialogue('It’s been exciting but a bit overwhelming. There’s so much to learn.',
            $mcCharacterId);

        $scene8->sceneable()->associate($dialogue8);
        $scene8->save();

        // 9
        $scene9 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue9 = $this->createDialogue('That’s understandable. Adjusting takes time. If you need help, we’re here for you. In fact, maybe you can help us too.',
            $agungCharacterId);

        $scene9->sceneable()->associate($dialogue9);
        $scene9->save();

        // 10
        $scene10 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue10 = $this->createDialogue('Help you? With what?',
            $mcCharacterId);

        $scene10->sceneable()->associate($dialogue10);
        $scene10->save();

        // 11
        $scene11 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue11 = $this->createDialogue('Well, one of the students came to us with a problem. We’re trying to figure out how to help them, but we’re a bit stuck',
            $agathaCharacterId);

        $scene11->sceneable()->associate($dialogue11);
        $scene11->save();

        // 12
        $scene12 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue12 = $this->createDialogue('We thought your fresh perspective might help us come up with something creative. Care to give it a shot?',
            $agungCharacterId);

        $scene12->sceneable()->associate($dialogue12);
        $scene12->save();

        $dialogue_option_12a = $this->createDialogueOption($dialogue12->id, 'Absolutely, let’s work on it.');
        $dialogue_option_12b = $this->createDialogueOption($dialogue12->id, 'I’ll do my best to help.');
        $dialogue_option_12c = $this->createDialogueOption($dialogue12->id, 'Let’s tackle this together.');

        $scene12a = $this->createScene($activityId, 'hallway.jpg');
        $dialogue12a = $this->createDialogue('Absolutely, let’s work on it.',
            $mcCharacterId);

        $scene12a->sceneable()->associate($dialogue12a);
        $scene12a->save();


        $scene12b = $this->createScene($activityId, 'hallway.jpg');
        $dialogue12b = $this->createDialogue('I’ll do my best to help.',
            $mcCharacterId);

        $scene12b->sceneable()->associate($dialogue12b);
        $scene12b->save();


        $scene12c = $this->createScene($activityId, 'hallway.jpg');
        $dialogue12c = $this->createDialogue('Let’s tackle this together.',
            $mcCharacterId);

        $scene12c->sceneable()->associate($dialogue12c);
        $scene12c->save();


        // Minigame
        $scene13 = $this->createScene($activityId, 'hallway.jpg');
        $minigame13 = $this->createStoryCase();

        $scene13->sceneable()->associate($minigame13);
        $scene13->save();

        // 14
        $scene14 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue14 = $this->createDialogue('That was amazing! Your solution is exactly what we needed.',
            $agathaCharacterId);
    
        $scene14->sceneable()->associate($dialogue14);
        $scene14->save();
    
        // 15
        $scene15 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue15 = $this->createDialogue('You’ve really helped that student. Your problem-solving skills are impressive!',
            $agungCharacterId);
    
        $scene15->sceneable()->associate($dialogue15);
        $scene15->save();
    
        // 16
        $scene16 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue16 = $this->createDialogue('I’m glad I could help. Teamwork makes a difference.',
            $mcCharacterId);
    
        $scene16->sceneable()->associate($dialogue16);
        $scene16->save();
    
        // 17
        $scene17 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue17 = $this->createDialogue('I’ll make sure to share this story in the News Club. It’s a great example of collaboration.',
            $agathaCharacterId);
    
        $scene17->sceneable()->associate($dialogue17);
        $scene17->save();
    
        // 18
        $scene18 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue18 = $this->createDialogue('And I’ll let the student know, thanks for stepping up!',
            $agungCharacterId);
    
        $scene18->sceneable()->associate($dialogue18);
        $scene18->save();
    
        // 19
        $scene19 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue19 = $this->createDialogue('Anytime! Let me know if there’s more I can do.',
            $mcCharacterId);
    
        $scene19->sceneable()->associate($dialogue19);
        $scene19->save();
    
        // 20
        $scene20 = $this->createScene($activityId, 'hallway.jpg');
        $dialogue20 = $this->createDialogue('Oh, we’ll definitely call you again. You’re a natural at this!',
            $agathaCharacterId);
    
        $scene20->sceneable()->associate($dialogue20);
        $scene20->save();
    
        // 21
        $scene21 = $this->createScene($activityId, 'hallway.jpg', false, true);
        $dialogue21 = $this->createDialogue('With your problem-solving skills, I’m sure you’ll make an amazing Beescholar. Keep it up!',
            $agungCharacterId);
    
        $scene21->sceneable()->associate($dialogue21);
        $scene21->save();

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

        $scene8->update([
            'next_scene_id' => $scene9->id
        ]);

        $scene9->update([
            'next_scene_id' => $scene10->id
        ]);

        $scene10->update([
            'next_scene_id' => $scene11->id
        ]);

        $scene11->update([
            'next_scene_id' => $scene12->id
        ]);

        $dialogue_option_12a->update([
            'next_scene_id' => $scene12a->id
        ]);

        $dialogue_option_12b->update([
            'next_scene_id' => $scene12b->id
        ]);

        $dialogue_option_12c->update([
            'next_scene_id' => $scene12c->id
        ]);

        $scene12a->update([
            'next_scene_id' => $scene13->id
        ]);

        $scene12b->update([
            'next_scene_id' => $scene13->id
        ]);

        $scene12c->update([
            'next_scene_id' => $scene13->id
        ]);

        $scene13->update([
            'next_scene_id' => $scene14->id
        ]);
        
        $scene14->update([
            'next_scene_id' => $scene15->id
        ]);
        
        $scene15->update([
            'next_scene_id' => $scene16->id
        ]);
        
        $scene16->update([
            'next_scene_id' => $scene17->id
        ]);
        
        $scene17->update([
            'next_scene_id' => $scene18->id
        ]);
        
        $scene18->update([
            'next_scene_id' => $scene19->id
        ]);
        
        $scene19->update([
            'next_scene_id' => $scene20->id
        ]);

        $scene20->update([
            'next_scene_id' => $scene21->id
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

    public function createStoryCase()
    {
        $agungCharacterId = Character::where('character_name', 'Agung')->first()->id;
        $agathaCharacterId = Character::where('character_name', 'Agatha')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        $minigame = Minigame::create([
            'minigame_name' => 'BINUS Academic Assistance',
            'instruction' => 'Answer questions to guide students with common academic tasks.',
            'maximum_point_reward' => 100,
            'minimum_passing_point' => 50,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        // Step 2: Create the Quiz
        $quiz = Quiz::create([
            'quiz_type' => 'Story Case',
            'quiz_topic' => 'General Information on Academic Activities',
            'hint' => 'The answers are based on BINUS academic procedures.',
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        // Link the Quiz to the Minigame
        $minigame->minigameable()->associate($quiz);
        $minigame->save();

        // Step 3: Create Quiz Questions and Choices

        // Question 1
        $question1 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question_title' => 'How can a student get their @binus.ac.id username?',
            'question_type' => 'Multiple Choice',
            'question_point' => 25,
            'character_id' => $agungCharacterId,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'Visit BINUSMAYA and click "GET YOUR USERNAME".',
            'is_correct' => true,
            'question_id' => $question1->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'Request it from your lecturer.',
            'is_correct' => false,
            'question_id' => $question1->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'Contact the BINUS IT Support team directly.',
            'is_correct' => false,
            'question_id' => $question1->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        // Question 2
        $question2 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question_title' => 'Where can a student find the Academic Calendar?',
            'question_type' => 'Multiple Choice',
            'question_point' => 25,
            'character_id' => $agungCharacterId,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'In BINUSMAYA under Schedule > View Academic Calendar.',
            'is_correct' => true,
            'question_id' => $question2->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'On the BINUS website homepage.',
            'is_correct' => false,
            'question_id' => $question2->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'Through the Student Service Center.',
            'is_correct' => false,
            'question_id' => $question2->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        // Question 3
        $question3 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question_title' => 'Why should students check their course curriculum?',
            'question_type' => 'Multiple Choice',
            'question_point' => 25,
            'character_id' => $agungCharacterId,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'To prepare for the upcoming semester and track completed courses.',
            'is_correct' => true,
            'question_id' => $question3->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'To get extra credit for past semesters.',
            'is_correct' => false,
            'question_id' => $question3->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'To avoid attending unnecessary classes.',
            'is_correct' => false,
            'question_id' => $question3->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        // Question 4
        $question4 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question_title' => 'Where can attendance requirements for exams be checked?',
            'question_type' => 'Multiple Choice',
            'question_point' => 25,
            'character_id' => $agungCharacterId,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'In BINUSMAYA under Academic Services > Attendance Information.',
            'is_correct' => true,
            'question_id' => $question4->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'Through the Student Handbook.',
            'is_correct' => false,
            'question_id' => $question4->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        QuizChoice::create([
            'choice_text' => 'From the Student Affairs Office.',
            'is_correct' => false,
            'question_id' => $question4->id,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null
        ]);

        return $minigame;
    }
}
