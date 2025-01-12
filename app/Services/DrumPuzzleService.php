<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\DrumPuzzle;
use App\Models\DrumPuzzleAnswer;
use App\Models\MinigameAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class DrumPuzzleService
{
    public function getDrumPuzzleMinigame($minigameableId){
        return DrumPuzzle::findOrFail($minigameableId);
    }

    public function createDrumPuzzleAnswer($minigameAttemptId, $point, $patternAnswer)
    {
        $minigameAnswer = MinigameAnswer::create(
            [
                'status' => 'Completed',
                'answer_point' => $point,
                'minigame_attempt_id' => $minigameAttemptId,
            ]
        );

        $drumPuzzleAnswer = DrumPuzzleAnswer::create(
            [
                'pattern_answer' => $patternAnswer
            ]
        );

        $minigameAnswer->answerable()->associate($drumPuzzleAnswer);
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'crosswordAnswer' => $drumPuzzleAnswer
        ];
    }

    public function updateDrumPuzzleAnswer(string $minigameAttemptId, $point, $patternAnswer){
        $listMinigameAnswers = MinigameAnswer::where('minigame_attempt_id', $minigameAttemptId)->get();

        $answerableType = config('minigame_answer_types')['Drum Puzzle Answer'];
        $answerableIds = $listMinigameAnswers->where('answerable_type', $answerableType)
            ->pluck('answerable_id');

        $drumPuzzleAnswer = DrumPuzzleAnswer::whereIn('id', $answerableIds)->first();

        $drumPuzzleAnswer->pattern_answer = $patternAnswer;

        $minigameAnswer = $listMinigameAnswers->where('answerable_id', $drumPuzzleAnswer->id)->first();

        $minigameAnswer->answer_point = $point;
        $minigameAnswer->save();

        return [
            'minigameAnswer' => $minigameAnswer,
            'crosswordAnswer' => $drumPuzzleAnswer
        ];
    }
}
