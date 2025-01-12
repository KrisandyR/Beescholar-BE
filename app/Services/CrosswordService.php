<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Crossword;
use App\Models\CrosswordAnswer;
use App\Models\CrosswordWord;
use App\Models\MinigameAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CrosswordService
{
    public function getCrosswordMinigame($minigameableId) {
        $crossword = Crossword::findOrFail($minigameableId);
        $crossword->words = $crossword->crosswordWords()->get();

        if($crossword->words->isEmpty()){
            throw ValidationException::withMessages([
                'words' => 'Crossword words are empty',
            ]);
        }

        return $crossword;
    }

    public function validateCrosswordAnswer($wordId, $answerText)
    {
        $word = CrosswordWord::findOrFail($wordId);
        return trim(strtoupper($word->word_answer)) === trim(strtoupper($answerText));
    }

    public function createCrosswordAnswer(string $minigameAttemptId, $wordId, $answerText, $point){
        $minigameAnswer = MinigameAnswer::create(
            [
                'status' => 'Completed',
                'answer_point' => $point,
                'minigame_attempt_id' => $minigameAttemptId,
            ]
        );

        $crosswordAnswer = CrosswordAnswer::create(
            [
                'word_id' => $wordId,
                'word_answer' => $answerText,
                'is_correct' => true
            ]
        );

        $minigameAnswer->answerable()->associate($crosswordAnswer);
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'crosswordAnswer' => $crosswordAnswer
        ];
    }

    public function updateCrosswordAnswer(string $minigameAttemptId, $wordId, $answerText, $point){
        $listMinigameAnswers = MinigameAnswer::where('minigame_attempt_id', $minigameAttemptId)->get();

        $answerableType = config('minigame_answer_types')['Crossword Answer'];
        $answerableIds = $listMinigameAnswers->where('answerable_type', $answerableType)
            ->pluck('answerable_id');

        $crosswordAnswer = CrosswordAnswer::where(
            'word_id', $wordId
        )->whereIn('id', $answerableIds)->first();

        $crosswordAnswer->word_answer = $answerText;
        $crosswordAnswer->is_correct = true;
        $crosswordAnswer->save();

        $minigameAnswer = $listMinigameAnswers->where('answerable_id', $crosswordAnswer->id)->first();

        $minigameAnswer->answer_point = $point;
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'crosswordAnswer' => $crosswordAnswer
        ];
    }

}
