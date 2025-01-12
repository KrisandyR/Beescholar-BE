<?php

namespace App\Http\DTOs\SubmitCrossword;

use Illuminate\Http\Request;

class SubmitCrosswordDTO
{
    public string $minigameId;
    public ?array $wordAnswers; // Nullable for optional field

    public function __construct(Request $request)
    {
        $validatedData = $request->validate([
            'minigameId' => 'required|uuid',
            'wordAnswers' => 'nullable|array', // Optional field
            'wordAnswers.*.wordId' => 'required_with:wordAnswers|uuid', // Only validate when wordAnswers exists
            'wordAnswers.*.answerText' => 'required_with:wordAnswers|string|max:255',
        ]);

        $this->minigameId = $validatedData['minigameId'];
        $this->wordAnswers = isset($validatedData['wordAnswers'])
            ? array_map(fn($word) => new WordAnswerDTO($word), $validatedData['wordAnswers'])
            : null;
    }
}
