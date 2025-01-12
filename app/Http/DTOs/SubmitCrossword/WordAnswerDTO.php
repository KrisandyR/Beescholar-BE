<?php

namespace App\Http\DTOs\SubmitCrossword;

class WordAnswerDTO
{
    public string $wordId;
    public string $answerText;

    public function __construct(array $data)
    {
        $this->wordId = $data['wordId'];
        $this->answerText = $data['answerText'];
    }
}
