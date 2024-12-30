<?php

namespace App\Http\Resources\Minigame;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'questionId' => $this->id,
            'questionTitle' => $this->question_title,
            'questionType' => $this->question_type,
            'questionPoint' => $this->question_point,
            'characterName' => $this->character_name,
            'choices' => $this->when($this->choices->isNotEmpty(),
                QuizChoiceResource::collection($this->choices)),
            'steps' => $this->when($this->steps->isNotEmpty(),
                QuizStepResource::collection($this->steps)),
        ];
    }
}

