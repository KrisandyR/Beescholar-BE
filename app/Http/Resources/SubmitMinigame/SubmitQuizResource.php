<?php

namespace App\Http\Resources\SubmitMinigame;

use App\Http\Resources\SubmitMinigame\QuizMultipleChoiceResultResource;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmitQuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $totalCorrect = 0;
        $totalPoint = 0;
        
        foreach ($this->quizChoiceResults as $choiceResult) {
            if ($choiceResult->quizMinigameAnswer->quizMultipleChoiceAnswer->is_correct){
                $totalCorrect += 1;
            }
            $totalPoint += $choiceResult->quizMinigameAnswer->minigameAnswer->answer_point;
        }

        foreach ($this->quizStepsResults as $stepResult) {
            if ($stepResult->quizMinigameAnswer->quizOrderStepsAnswer->is_correct){
                $totalCorrect += 1;
            }
            $totalPoint += $stepResult->quizMinigameAnswer->minigameAnswer->answer_point;
        }

        $totalIncorrect = $this->quizChoiceResults->count() + $this->quizStepsResults->count()
            - $totalCorrect;

        return [
            'minigameId' => $this->minigameId,
            'totalCorrect' => $totalCorrect,
            'totalIncorrect' => $totalIncorrect,
            'totalPoint' => $totalPoint,
            'quizMultipleChoiceResults' => QuizMultipleChoiceResultResource::collection($this->quizChoiceResults),
            'quizOrderStepsResults' => QuizOrderStepsResultResource::collection($this->quizStepsResults)
        ];
    }

}
