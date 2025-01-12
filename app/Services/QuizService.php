<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Character;
use App\Models\MinigameAnswer;
use App\Models\Quiz;
use App\Models\QuizChoice;
use App\Models\QuizMultipleChoiceAnswer;
use App\Models\QuizOrderStepsAnswer;
use App\Models\QuizOrderStepsAnswerDetail;
use App\Models\QuizQuestion;
use App\Models\QuizStep;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class QuizService
{

    public function getQuizMinigame(string $minigameableId)
    {
        $quiz = Quiz::findOrFail($minigameableId);
        $quiz->questions = $quiz->questions()->get();

        if($quiz->questions->isEmpty()){
            throw ValidationException::withMessages([
                'questions' => 'Questions is empty',
            ]);
        }
    
        foreach ($quiz->questions as $question) {

            $character = Character::where('id', $question->character_id)->first();
            if ($character) {
                $question->character_name = $character->character_name;
                $question->character_image =  $character->character_image;
            }

            if ($question->type === QuizQuestion::TYPE_MULTIPLE_CHOICE || $question->type === QuizQuestion::TYPE_YES_NO) {
                $question->choices = $question->choices();
            } elseif ($question->type === QuizQuestion::TYPE_REORDER_STEPS) {
                $question->steps = $question->steps();
            }
    
            $this->validateQuestion($question);
        }

        return $quiz;
    }

    public function validateQuestion($question)
    {
        if (!in_array($question->question_type, [
            QuizQuestion::TYPE_MULTIPLE_CHOICE,
            QuizQuestion::TYPE_YES_NO,
            QuizQuestion::TYPE_REORDER_STEPS,
        ])) {
            throw ValidationException::withMessages([
                'type' => 'Invalid question type.',
            ]);
        }
    
        if (in_array($question->question_type, [
            QuizQuestion::TYPE_MULTIPLE_CHOICE,
            QuizQuestion::TYPE_YES_NO,
        ]) && $question->choices->isEmpty()) {
            throw ValidationException::withMessages([
                'choices' => 'Choices cannot be empty for this question type.',
            ]);
        }
    
        if ($question->question_type === QuizQuestion::TYPE_REORDER_STEPS && $question->steps->isEmpty()) {
            throw ValidationException::withMessages([
                'steps' => 'Steps cannot be empty for reorder steps question type.',
            ]);
        }
    }
    
    public function getQuizQuestionPoint($questionId){
        return QuizQuestion::findOrFail($questionId)->question_point;
    }

    public function validateQuizMultipleChoiceAnswer(string $choiceId)
    {
        $userChoice = QuizChoice::findOrFail($choiceId);

        return $userChoice->is_correct;
    }

    public function validateQuizOrderStepsAnswer($answerStepIds, $questionId)
    {
        $correctSteps = QuizStep::where('question_id', $questionId)
            ->orderBy('step_order', 'asc')->get();
        
        if($correctSteps->count() != count($answerStepIds)){
            throw ValidationException::withMessages([
                'quiz answer order steps' => 'Quiz Steps Answer doesnt match the count of Steps for the Question',
            ]);
        }

        $idx = 0;
        foreach($correctSteps as $step){
            if($step->id != $answerStepIds[$idx]){
                return false;
            }
            $idx+=1;
        }

        return true;
    }

    public function createQuizMultipleChoiceAnswer(string $minigameAttemptId, $questionId, $choiceId, $point, $isCorrect){
        $minigameAnswer = MinigameAnswer::create(
            [
                'answer_point' => $point, // default 0
                'status' => 'Completed',
                'minigame_attempt_id' => $minigameAttemptId,
            ]
        );

        dump($choiceId);
        dump($isCorrect);
        dump($questionId);

        $quizMultipleChoiceAnswer = QuizMultipleChoiceAnswer::create(
            [
                'answer_choice_id' => $choiceId,
                'is_correct' => $isCorrect,
                'question_id' => $questionId
            ]
        );

        $minigameAnswer->answerable()->associate($quizMultipleChoiceAnswer);
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'quizMultipleChoiceAnswer' => $quizMultipleChoiceAnswer
        ];
    }

    public function updateQuizMultipleChoiceAnswer(string $minigameAttemptId, $questionId, $choiceId, $point, $isCorrect){
        dump('updating');
        $listMinigameAnswers = MinigameAnswer::where('minigame_attempt_id', $minigameAttemptId)->get();

        $answerableType = config('minigame_answer_types')['Quiz Multiple Choice Answer'];
        $answerableIds = $listMinigameAnswers->where('answerable_type', $answerableType)
            ->pluck('answerable_id');

        $quizMultipleChoiceAnswer = QuizMultipleChoiceAnswer::where(
            'question_id', $questionId
        )->whereIn('id', $answerableIds)->first();

        $quizMultipleChoiceAnswer->answer_choice_id = $choiceId;
        $quizMultipleChoiceAnswer->is_correct = $isCorrect;
        $quizMultipleChoiceAnswer->save();

        $minigameAnswer = $listMinigameAnswers->where('answerable_id', $quizMultipleChoiceAnswer->id)->first();

        $minigameAnswer->answer_point = $point;
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'quizMultipleChoiceAnswer' => $quizMultipleChoiceAnswer
        ];
    }

    public function createQuizOrderStepsAnswer(string $minigameAttemptId, $questionId, $stepIds, $point, $isCorrect)
    {
        
        $minigameAnswer = MinigameAnswer::create([
            'answer_point' => $point, // default 0
            'status' => 'Completed',
            'minigame_attempt_id' => $minigameAttemptId
        ]);

        $quizOrderStepsAnswer = QuizOrderStepsAnswer::create([
            'is_correct' => $isCorrect,
            'question_id' => $questionId
        ]);

        $minigameAnswer->answerable()->associate($quizOrderStepsAnswer);
        $minigameAnswer->save();

        $quizOrderStepsAnswer->steps = collect();

        $stepOrder = 1;
        foreach($stepIds as $stepId){
            $step = QuizOrderStepsAnswerDetail::create([
                'answer_step_id' => $stepId,
                'answer_step_order' => $stepOrder,
                'user_answer_id' => $quizOrderStepsAnswer->id,
            ]);
            $quizOrderStepsAnswer->steps->push($step);
            $stepOrder += 1;
        }

        return [
            'minigameAnswer' => $minigameAnswer,
            'quizOrderStepsAAnswer' => $quizOrderStepsAnswer
        ];
    }

    public function updateQuizOrderStepsAnswer($minigameAttemptId, $questionId, $stepIds, $point, $isCorrect)
    {
        $listMinigameAnswers = MinigameAnswer::where('minigame_attempt_id', $minigameAttemptId)->get();

        $answerableType = config('minigame_answer_types')['Quiz Order Steps Answer'];
        $answerableIds = $listMinigameAnswers->where('answerable_type', $answerableType)
            ->pluck('answerable_id');

        $quizOrderStepsAnswer = QuizOrderStepsAnswer::where(
            'question_id', $questionId
        )->whereIn('id', $answerableIds)->first();

        $quizOrderStepsAnswer->is_correct = $isCorrect;
        $quizOrderStepsAnswer->save();

        $quizOrderStepAnswerDetails = $quizOrderStepsAnswer->details()
            ->orderBy('answer_step_order', 'asc')->get();

        $quizOrderStepsAnswer->steps = collect();
        $idx = 0;
        foreach($quizOrderStepAnswerDetails as $detail) {
            $detail->answer_step_id = $stepIds[$idx];
            $detail->answer_step_order = $idx + 1;
            $detail->save();
            $quizOrderStepsAnswer->steps->push($detail);
            $idx += 1;
        }

        $minigameAnswer = $listMinigameAnswers->where('answerable_id', $quizOrderStepsAnswer->id)->first();

        $minigameAnswer->answer_point = $point;
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'quizOrderStepsAnswer' => $quizOrderStepsAnswer
        ];
    }

}
