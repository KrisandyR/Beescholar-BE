<?php

namespace App\Http\DTOs\SubmitQuiz;

class StepAnswerDTO
{
    public string $questionId;
    public int $questionOrder;
    public array $stepIds;

    public function __construct(array $data)
    {
        $this->questionId = $data['questionId'];
        $this->questionOrder = $data['questionOrder'];
        $this->stepIds = $data['stepIds'];
    }
}
