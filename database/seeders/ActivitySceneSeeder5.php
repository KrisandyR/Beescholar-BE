<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Character;
use App\Models\Dialogue;
use App\Models\DialogueOption;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\Quest;
use App\Models\Quiz;
use App\Models\QuizChoice;
use App\Models\QuizQuestion;
use App\Models\QuizStep;
use App\Models\Scene;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySceneSeeder5 extends Seeder
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
                ->where('activity_name', 'Stage')
                ->first();
        
            if ($first_activity) {
                echo "Found activity: " . $first_activity->activity_name . " for quest " . $quest->id . "\n";
                $this->createStageDialogueFlow($first_activity->id);
            } else {
                echo "No 'Stage' activity found for quest " . $quest->id . "\n";
            }
        }
    }

    public function createStageDialogueFlow(string $activityId)
    {
        $diyanCharacterId = Character::where('character_name', 'Diyan')->first()->id;
        $ehanCharacterId = Character::where('character_name', 'Ehan')->first()->id;
        $dianaCharacterId = Character::where('character_name', 'Diana')->first()->id;
        $agungCharacterId = Character::where('character_name', 'Agung')->first()->id;
        $mcCharacterId = Character::where('character_name', '[MC]')->first()->id;

        // 1
        $scene1 = $this->createScene($activityId, '/backgrounds/Classroom.png', true, false);
        $dialogue1 = $this->createDialogue('Ah, [MC]! Right on time. Please, take a seat. We have much to discuss.', $diyanCharacterId);

        $scene1->sceneable()->associate($dialogue1);
        $scene1->save();

        // 2
        $scene2 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue2 = $this->createDialogue('As a Beescholar candidate, your journey here is more than academics. It’s about leadership, perseverance, and proving your worth.', $diyanCharacterId);

        $scene2->sceneable()->associate($dialogue2);
        $scene2->save();

        // 3
        $scene3 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue3 = $this->createDialogue('Proving my worth? What do you mean, Mr. Diyan?', $mcCharacterId);

        $scene3->sceneable()->associate($dialogue3);
        $scene3->save();

        // 4
        $scene4 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue4 = $this->createDialogue('You’ll face a Stage—a series of challenges designed to test your quick thinking, problem-solving, and communication. Think of it as a rite of passage.', $diyanCharacterId);

        $scene4->sceneable()->associate($dialogue4);
        $scene4->save();

        // 5
        $scene5 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue5 = $this->createDialogue('I’ll guide you through a tutorial first. It will help you understand what each type of question entails. Pay attention—this knowledge will be vital.', $diyanCharacterId);

        $scene5->sceneable()->associate($dialogue5);
        $scene5->save();

        // 6
        $scene6 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $event6 = Event::create([
            'event_name' => 'Stage Tutorial',
            'event_type' => 'Tutorial'
        ]);

        $scene6->sceneable()->associate($event6);
        $scene6->save();

        // 7
        $scene7 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue7 = $this->createDialogue('Hey, [MC]! Ready to rock the Stage? I heard it’s no walk in the park, but I’m sure you’ll nail it.', $ehanCharacterId);

        $dialogue_option_7a = $this->createDialogueOption($dialogue7->id, 'Thanks, Ehan! I’ll do my best.');
        $dialogue_option_7b = $this->createDialogueOption($dialogue7->id, 'Rock the Stage? Sounds intimidating!');
        $dialogue_option_7c = $this->createDialogueOption($dialogue7->id, 'Any chance I can skip this?');
        $scene7->sceneable()->associate($dialogue7);
        $scene7->save();

        // Branch 1:
        $scene7a = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue7a = $this->createDialogue('Alright, I’ll give it a try.', $mcCharacterId);
        $scene7a->sceneable()->associate($dialogue7a);
        $scene7a->save();

        $scene8a = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue8a = $this->createDialogue('That’s the spirit! Just focus, and you’ll be great.', $ehanCharacterId);
        $scene8a->sceneable()->associate($dialogue8a);
        $scene8a->save();

        // Branch 2:
        $scene7b = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue7b = $this->createDialogue('Rock the Stage? Sounds intimidating!', $mcCharacterId);
        $scene7b->sceneable()->associate($dialogue7b);
        $scene7b->save();

        $scene8b = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue8b = $this->createDialogue('Yeah, it can be. But you’ve got this. Just treat it like a jam session—go with the flow.', $ehanCharacterId);
        $scene8b->sceneable()->associate($dialogue8b);
        $scene8b->save();

        // Branch 3:
        $scene7c = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue7c = $this->createDialogue('Any chance I can skip this?', $mcCharacterId);
        $scene7c->sceneable()->associate($dialogue7c);
        $scene7c->save();

        $scene8c = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue8c = $this->createDialogue('Skip? (laughs) Nope, no skipping. But hey, I’ll be cheering for you!', $ehanCharacterId);
        $scene8c->sceneable()->associate($dialogue8c);
        $scene8c->save();

        // 9
        $scene9 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue9 = $this->createDialogue('Alright, let’s get this over with.', $mcCharacterId);

        $scene9->sceneable()->associate($dialogue9);
        $scene9->save();

        // 10
        $scene10 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue10 = $this->createDialogue('Don’t forget, the Stage is about showing who you are. Confidence is key. And maybe… a little luck.', $dianaCharacterId);

        $scene10->sceneable()->associate($dialogue10);
        $scene10->save();

        // 11
        $scene11 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue11 = $this->createDialogue('Everyone, attention! Candidates, please take your seats and prepare for the first challenge. Remember, you need at least 70 points to move forward.', $agungCharacterId);

        $scene11->sceneable()->associate($dialogue11);
        $scene11->save();

        // 12
        $scene12 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue12 = $this->createDialogue('The Stage begins now. Show us what you’re made of, Beescholars!', $agungCharacterId);

        $scene12->sceneable()->associate($dialogue12);
        $scene12->save();

        // Minigame Trigger
        $scene13 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $minigame13 = $this->createStageMinigame();

        $scene13->sceneable()->associate($minigame13);
        $scene13->save();

        // Post-Minigame Dialogue
        // 14
        $scene14 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue14 = $this->createDialogue('See? That wasn’t so bad. You’ve got this, [MC]!', $ehanCharacterId);

        $scene14->sceneable()->associate($dialogue14);
        $scene14->save();

        // 15
        $scene15 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue15 = $this->createDialogue('You nailed it! I knew you could do it.', $dianaCharacterId);

        $scene15->sceneable()->associate($dialogue15);
        $scene15->save();

        // 16
        $scene16 = $this->createScene($activityId, '/backgrounds/Classroom.png');
        $dialogue16 = $this->createDialogue('Let’s just hope I don’t mess up the next Stage.', $mcCharacterId);

        $scene16->sceneable()->associate($dialogue16);
        $scene16->save();

        // 17
        $scene17 = $this->createScene($activityId, '/backgrounds/Classroom.png', false, true);
        $dialogue17 = $this->createDialogue('One step at a time. Take this moment to rest and reflect. There’s more to come.', $agungCharacterId);

        $scene17->sceneable()->associate($dialogue17);
        $scene17->save();

        // Update Branches
        $dialogue_option_7a->update(['next_scene_id' => $scene7a->id]);
        $dialogue_option_7b->update(['next_scene_id' => $scene7b->id]);
        $dialogue_option_7c->update(['next_scene_id' => $scene7c->id]);
        $scene7a->update(['next_scene_id' => $scene8a->id]);
        $scene7b->update(['next_scene_id' => $scene8b->id]);
        $scene7c->update(['next_scene_id' => $scene8c->id]);
        $scene8a->update(['next_scene_id' => $scene9->id]);
        $scene8b->update(['next_scene_id' => $scene9->id]);
        $scene8c->update(['next_scene_id' => $scene9->id]);

        // Scene Linking
        $scene1->update(['next_scene_id' => $scene2->id]);
        $scene2->update(['next_scene_id' => $scene3->id]);
        $scene3->update(['next_scene_id' => $scene4->id]);
        $scene4->update(['next_scene_id' => $scene5->id]);
        $scene5->update(['next_scene_id' => $scene6->id]);
        $scene6->update(['next_scene_id' => $scene7->id]);
        $scene9->update(['next_scene_id' => $scene10->id]);
        $scene10->update(['next_scene_id' => $scene11->id]);
        $scene11->update(['next_scene_id' => $scene12->id]);
        $scene12->update(['next_scene_id' => $scene13->id]);
        $scene13->update(['next_scene_id' => $scene14->id]);
        $scene14->update(['next_scene_id' => $scene15->id]);
        $scene15->update(['next_scene_id' => $scene16->id]);
        $scene16->update(['next_scene_id' => $scene17->id]);
    }

    public function createStageMinigame()
    {

        $minigame = Minigame::create([
            'minigame_name' => 'Exam Preparation Quiz',
            'instruction' => 'Test your knowledge on exam preparation at BINUS University.',
            'maximum_point_reward' => 100,
            'minimum_passing_point' => 70,
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);

        $quiz = Quiz::create([
            'quiz_type' => 'Stage',
            'quiz_topic' => 'Exam.',
            'hint' => 'Refer to BINUSMAYA guidelines and student policies.',
            'created_by' => 'SceneDialogueSeeder',
            'updated_by' => null,
        ]);


        $minigame->minigameable()->associate($quiz);
        $minigame->save();

        // Questions and Answers
        $questions = [
            [
                'type' => 'Multiple Choice',
                'title' => 'What is required to attend the final exam at BINUS University?',
                'point' => 10,
                'choices' => [
                    ['text' => 'Full payment of tuition fees', 'correct' => true],
                    ['text' => 'Attendance below 50%', 'correct' => false],
                    ['text' => 'No profile photo on BINUSMAYA', 'correct' => false],
                    ['text' => 'No required documents submitted', 'correct' => false],
                ],
            ],
            [
                'type' => 'Yes or No',
                'title' => 'Can students access the exam schedule via BINUSMAYA Mobile?',
                'point' => 5,
                'choices' => [
                    ['text' => 'Yes', 'correct' => true],
                    ['text' => 'No', 'correct' => false],
                ],
            ],
            [
                'type' => 'Reorder Steps',
                'title' => 'Arrange the steps to project a non-PPT file onto the screen.',
                'point' => 15,
                'steps' => [
                    ['text' => 'Click start link Zoom from BINUSMAYA LMS', 'order' => 1],
                    ['text' => 'Drag the file to the projector screen', 'order' => 2],
                    ['text' => 'Click "Share Screen" in Zoom', 'order' => 3],
                    ['text' => 'Select "Screen 2" and click Share', 'order' => 4],
                ],
            ],
            [
                'type' => 'Multiple Choice',
                'title' => 'What documents are required for exam attendance?',
                'point' => 10,
                'choices' => [
                    ['text' => 'Birth Certificate and Flazz Card', 'correct' => true],
                    ['text' => 'Library fine receipts', 'correct' => false],
                    ['text' => 'Extra-curricular attendance sheet', 'correct' => false],
                ],
            ],
            [
                'type' => 'Yes or No',
                'title' => 'Is attendance above 75% mandatory to take the final exam?',
                'point' => 5,
                'choices' => [
                    ['text' => 'Yes', 'correct' => true],
                    ['text' => 'No', 'correct' => false],
                ],
            ],
            [
                'type' => 'Multiple Choice',
                'title' => 'What happens if a student misses an exam due to hospitalization?',
                'point' => 10,
                'choices' => [
                    ['text' => 'They must submit proof within one day.', 'correct' => true],
                    ['text' => 'They automatically fail the exam.', 'correct' => false],
                    ['text' => 'They reschedule without proof.', 'correct' => false],
                ],
            ],
            [
                'type' => 'Reorder Steps',
                'title' => 'Arrange the steps to check attendance for an ongoing semester.',
                'point' => 15,
                'steps' => [
                    ['text' => 'Log in to BINUSMAYA', 'order' => 1],
                    ['text' => 'Go to Academic Services', 'order' => 2],
                    ['text' => 'Select Attendance Information', 'order' => 3],
                    ['text' => 'Choose the current semester and subject', 'order' => 4],
                ],
            ],
            [
                'type' => 'Yes or No',
                'title' => 'Are students allowed to request a make-up exam for force majeure cases?',
                'point' => 5,
                'choices' => [
                    ['text' => 'Yes', 'correct' => true],
                    ['text' => 'No', 'correct' => false],
                ],
            ],
            [
                'type' => 'Multiple Choice',
                'title' => 'Which platform provides exam schedules at BINUS?',
                'point' => 10,
                'choices' => [
                    ['text' => 'BINUSMAYA Academic Services', 'correct' => true],
                    ['text' => 'Library Information Desk', 'correct' => false],
                    ['text' => 'BINUS Career Center', 'correct' => false],
                ],
            ],
            [
                'type' => 'Reorder Steps',
                'title' => 'Arrange the steps to request a make-up exam.',
                'point' => 15,
                'steps' => [
                    ['text' => 'Log in to BINUSMAYA', 'order' => 1],
                    ['text' => 'Go to Student Services > E-Form', 'order' => 2],
                    ['text' => 'Select "Make Up Exam"', 'order' => 3],
                    ['text' => 'Submit the required evidence', 'order' => 4],
                ],
            ],
        ];

        // Save Questions and Answers
        foreach ($questions as $index => $question) {
            $quizQuestion = QuizQuestion::create([
                'question_title' => $question['title'],
                'question_type' => $question['type'],
                'question_point' => $question['point'],
                'quiz_id' => $quiz->id,
                'created_by' => 'SceneDialogueSeeder',
                'updated_by' => null,
            ]);

            if (isset($question['choices'])) {
                foreach ($question['choices'] as $choice) {
                    QuizChoice::create([
                        'choice_text' => $choice['text'],
                        'is_correct' => $choice['correct'],
                        'question_id' => $quizQuestion->id,
                        'created_by' => 'SceneDialogueSeeder',
                        'updated_by' => null,
                    ]);
                }
            }

            if (isset($question['steps'])) {
                foreach ($question['steps'] as $step) {
                    QuizStep::create([
                        'step_text' => $step['text'],
                        'step_order' => $step['order'],
                        'question_id' => $quizQuestion->id,
                        'created_by' => 'SceneDialogueSeeder',
                        'updated_by' => null,
                    ]);
                }
            }
        }

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