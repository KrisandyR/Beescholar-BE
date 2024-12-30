<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Character;
use App\Models\Quiz;
use App\Models\QuizQuestion;
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

            $character_name = Character::where('id', $question->character_id)->first()->character_name;
            $question->character_name = $character_name;

            if ($question->type === QuizQuestion::TYPE_MULTIPLE_CHOICE || $question->type === QuizQuestion::TYPE_YES_NO) {
                $question->choices = $question->choices();
            } elseif ($question->type === QuizQuestion::TYPE_REORDER_STEPS) {
                $question->steps = $question->steps();
            }
    
            $this->validateQuestion($question);
        }

        return $quiz;
    }

    private function validateQuestion($question)
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
}
