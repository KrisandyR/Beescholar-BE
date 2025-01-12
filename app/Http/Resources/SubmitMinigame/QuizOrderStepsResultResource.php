<?php

namespace App\Http\Resources\SubmitMinigame;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizOrderStepsResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'questionId' => $this->userStepAnswer->questionId,
            'stepIds' => $this->userStepAnswer->stepIds,
            'isCorrect' => $this->quizMinigameAnswer->quizOrderStepsAnswer->is_correct,
            'point' => $this->quizMinigameAnswer->minigameAnswer->answer_point
        ];
    }
}
