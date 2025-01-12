<?php

namespace App\Services;

use App\Http\Resources\Minigame\CrosswordResource;
use App\Http\Resources\Minigame\DrumPuzzleResource;
use App\Http\Resources\Minigame\QuizResource;
use App\Models\Crossword;
use App\Models\DrumPuzzle;
use App\Models\Minigame;
use App\Models\MinigameAttempt;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class MinigameService
{
    protected $quizService;
    protected $crosswordService;
    protected $drumPuzzleService;

    public function __construct(QuizService $quizService, CrosswordService $crosswordService, DrumPuzzleService $drumPuzzleService)
    {
        $this->quizService = $quizService;
        $this->crosswordService = $crosswordService;
        $this->drumPuzzleService = $drumPuzzleService;
    }
    // Consider moving to Repository
    public function findMinigame(string $minigameId)
    {
        return Minigame::find($minigameId) ? true : false;
    }

    public function getMinigame($minigameId)
    {
        // Initialize $data with fields from the minigame
        $minigame = Minigame::find($minigameId);

        $data = [
            'minigame_id' => $minigame->id,
            'minigame_name' => $minigame->minigame_name,
            'instruction' => $minigame->instruction,
            'minigameable_type' => $minigame->minigameable_type, // Needed for type mapping
            'maximum_point_reward' => $minigame->maximum_point_reward,
            'minimum_passing_point' => $minigame->minimum_passing_point ?? 0, // Default to 0 if null
        ];

        // Fetch details based on minigameable_type
        switch ($minigame->minigameable_type) {
            case Quiz::class:
                $detail = $this->quizService->getQuizMinigame($minigame->minigameable_id);
                $combinedData = new QuizResource((object) array_merge($data, $detail->toArray()));
                break;
            case Crossword::class:
                $detail =  $this->crosswordService->getCrosswordMinigame($minigame->minigameable_id);
                $combinedData = new CrosswordResource((object) array_merge($data, $detail->toArray()));
                break;
            case DrumPuzzle::class:
                $detail = $this->drumPuzzleService->getDrumPuzzleMinigame($minigame->minigameable_id);
                $combinedData = new DrumPuzzleResource( (object) array_merge($data, $detail->toArray()));
                break;
            default:
                throw ValidationException::withMessages([
                    'minigame type' => 'Invalid minigame type',
                ]);
        }

        return $combinedData;
    }

    public function findMinigameAttempt(string $minigameId, string $userId)
    {
        return MinigameAttempt::where('minigame_id', $minigameId)->
            where('user_id', $userId)->first();
    }

    public function createMinigameAttempt($minigameId, $userId)
    {
        return MinigameAttempt::create([
            'status' => 'Completed',
            'minigame_id' => $minigameId,
            'user_id' => $userId,
        ]);
    }

    public function addPointToMinigameAttempt($minigameAttemptId, $point)
    {
        $minigameAttempt = MinigameAttempt::findOrFail($minigameAttemptId);
        $minigameAttempt->addPoint($point);
    }

}
