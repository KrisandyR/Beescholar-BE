<?php

namespace App\Http\Resources\SubmitMinigame;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizMultipleChoiceResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'questionId' => $this->userChoiceAnswer->questionId,
            'choiceId' => $this->userChoiceAnswer->choiceId,
            'isCorrect' => $this->quizMinigameAnswer->quizMultipleChoiceAnswer->is_correct,
            'point' => $this->quizMinigameAnswer->minigameAnswer->answer_point
        ];
    }
}
