<?php

namespace App\Http\DTOs;

use Illuminate\Http\Request;

class SubmitQuizDTO
{
    public string $minigameId;
    public ?array $quizChoiceAnswers; // Nullable for optional field
    public ?array $quizStepAnswers;

    public function __construct(Request $request)
    {
        $validatedData = $request->validate([
            'minigameId' => 'required|uuid',
            'quizChoiceAnswers' => 'nullable|array|required_without:quizStepAnswers', // Required if quizStepAnswers is missing
            'quizChoiceAnswers.*.questionId' => 'required_with:quizChoiceAnswers|uuid', // Only validate when quizChoiceAnswers exists
            'quizChoiceAnswers.*.choiceId' => 'required_with:quizChoiceAnswers|uuid',
            'quizChoiceAnswers.*.questionOrder' => 'required_with:quizChoiceAnswers|integer',
            'quizStepAnswers' => 'nullable|array|required_without:quizChoiceAnswers', // Required if quizChoiceAnswers is missing
            'quizStepAnswers.*.questionId' => 'required_with:quizStepAnswers|uuid',
            'quizStepAnswers.*.questionOrder' => 'required_with:quizStepAnswers|integer',
            'quizStepAnswers.*.stepIds' => 'required_with:quizStepAnswers|array|min:1',
            'quizStepAnswers.*.stepIds.*' => 'required_with:quizStepAnswers|uuid',
        ]);

        $this->minigameId = $validatedData['minigameId'];
        $this->quizChoiceAnswers = isset($validatedData['quizChoiceAnswers'])
            ? array_map(fn($choice) => new ChoiceAnswerDTO($choice), $validatedData['quizChoiceAnswers'])
            : null;

        $this->quizStepAnswers = isset($validatedData['quizStepAnswers'])
            ? array_map(fn($step) => new StepAnswerDTO($step), $validatedData['quizStepAnswers'])
            : null;
    }
}
