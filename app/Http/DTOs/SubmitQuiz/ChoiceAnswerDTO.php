<?php

namespace App\Http\DTOs\SubmitQuiz;

class ChoiceAnswerDTO
{
    public string $questionId;
    public string $choiceId;
    public int $questionOrder;

    public function __construct(array $data)
    {
        $this->questionId = $data['questionId'];
        $this->choiceId = $data['choiceId'];
        $this->questionOrder = $data['questionOrder'];
    }
}
