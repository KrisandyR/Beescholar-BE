<?php

namespace App\Http\Controllers;

use App\Http\DTOs\SubmitQuiz\SubmitQuizDTO;
use App\Http\DTOs\SubmitCrossword\SubmitCrosswordDTO;
use App\Http\DTOs\SubmitDrumPuzzle\SubmitDrumPuzzleDTO;
use App\Http\Resources\SubmitMinigame\SubmitQuizResource;
use App\Services\CrosswordService;
use App\Services\DrumPuzzleService;
use App\Services\MinigameService;
use App\Services\PointService;
use App\Services\QuizService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class MinigameController extends Controller
{
    protected $minigameService;

    protected $quizService;
    protected $pointService;
    protected $crosswordService;
    protected $drumPuzzleService;

    public function __construct(MinigameService $minigameService, QuizService $quizService, PointService $pointService, CrosswordService $crosswordService, DrumPuzzleService $drumPuzzleService)
    {
        $this->minigameService = $minigameService;
        $this->quizService = $quizService;
        $this->crosswordService = $crosswordService;
        $this->pointService = $pointService;
        $this->drumPuzzleService = $drumPuzzleService;
    }
    public function getMinigame(string $minigameId)
    {
        try{
            if(!$this->minigameService->findMinigame($minigameId)){
                return response()->json([
                    'success' => false,
                    'message' => 'Minigame not found',
                ], 404);
            }

            $data = $this->minigameService->getMinigame($minigameId);

            return response()->json([
                'success' => true,
                'message' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }


    public function submitQuiz(Request $request)
    {
        $dto = new SubmitQuizDTO($request);
        $userId = config('constants.default_user_id');
    
        if (!$this->minigameService->findMinigame($dto->minigameId)) {
            return response()->json(['success' => false, 'message' => 'Minigame not found']);
        }
    
        $minigameAttempt = $this->minigameService->findMinigameAttempt($dto->minigameId, $userId);
        $isCompleted = $minigameAttempt !== null;
    
        if (!$isCompleted) {
            $minigameAttempt = $this->minigameService->createMinigameAttempt($dto->minigameId, $userId);
        }
    
        $quizChoiceAnswers = $dto->quizChoiceAnswers ?? [];
        $quizStepAnswers = $dto->quizStepAnswers ?? [];
        $quizChoiceResults = new Collection();
        $quizStepsResults = new Collection();
        $totalPoint = 0;
        $hasAnswer = $this->minigameService->hasAnswers($minigameAttempt->id);

        foreach ($quizChoiceAnswers as $choiceAnswer) {
            $quizChoiceResults->push(
                $this->processChoiceAnswer($minigameAttempt->id, $choiceAnswer, $hasAnswer, $totalPoint)
            );
        }
    
        foreach ($quizStepAnswers as $stepAnswer) {
            $quizStepsResults->push(
                $this->processStepAnswer($minigameAttempt->id, $stepAnswer, $hasAnswer, $totalPoint)
            );
        }
    
        if (!$isCompleted || $minigameAttempt->total_point != $totalPoint) {
            $minigameAttempt->total_point = $totalPoint;
            $minigameAttempt->save();
    
            $this->pointService->getPointFromMinigame($userId, $minigameAttempt);
            $minigameAttempt = $this->minigameService->setMinigameAttemptStatus($dto->minigameId, $userId, $totalPoint);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Minigame submitted successfully.',
            'data' => new SubmitQuizResource(
                (object) [
                    'status' => $minigameAttempt->status,
                    'minigameId' => $dto->minigameId,
                    'quizChoiceResults' => $quizChoiceResults,
                    'quizStepsResults' => $quizStepsResults
                ]
            )
        ]);
    }
    
    private function processChoiceAnswer($minigameAttemptId, $choiceAnswer, $hasAnswer, &$totalPoint)
    {
        $isCorrect = $this->quizService->validateQuizMultipleChoiceAnswer($choiceAnswer->choiceId);
        $answerPoint = $isCorrect ? $this->quizService->getQuizQuestionPoint($choiceAnswer->questionId) : 0;
        $totalPoint += $answerPoint;
    
        $quizMultipleChoiceAnswer = $hasAnswer
            ? $this->quizService->updateQuizMultipleChoiceAnswer($minigameAttemptId, $choiceAnswer->questionId, $choiceAnswer->choiceId, $answerPoint, $isCorrect)
            : $this->quizService->createQuizMultipleChoiceAnswer($minigameAttemptId, $choiceAnswer->questionId, $choiceAnswer->choiceId, $answerPoint, $isCorrect);
    
        return (object)[
            'userChoiceAnswer' => $choiceAnswer,
            'quizMinigameAnswer' => $quizMultipleChoiceAnswer,
        ];
    }
    
    private function processStepAnswer($minigameAttemptId, $stepAnswer, $hasAnswer, &$totalPoint)
    {
        $isCorrect = $this->quizService->validateQuizOrderStepsAnswer($stepAnswer->stepIds, $stepAnswer->questionId);
        $answerPoint = $isCorrect ? $this->quizService->getQuizQuestionPoint($stepAnswer->questionId) : 0;
        $totalPoint += $answerPoint;
    
        $quizOrderStepsAnswer = $hasAnswer
            ? $this->quizService->updateQuizOrderStepsAnswer($minigameAttemptId, $stepAnswer->questionId, $stepAnswer->stepIds, $answerPoint, $isCorrect)
            : $this->quizService->createQuizOrderStepsAnswer($minigameAttemptId, $stepAnswer->questionId, $stepAnswer->stepIds, $answerPoint, $isCorrect);
    
        return (object)[
            'userStepAnswer' => $stepAnswer,
            'quizMinigameAnswer' => $quizOrderStepsAnswer,
        ];
    }

    public function submitCrossword(Request $request)
    {
        $dto = new SubmitCrosswordDTO($request);
        $userId = config('constants.default_user_id');

        if(!$this->minigameService->findMinigame($dto->minigameId)){
            return response()->json(['success' => false, 'message' => 'Minigame not found']);
        }

        $minigameAttempt = $this->minigameService->findMinigameAttempt($dto->minigameId, $userId);
        $isCompleted = $minigameAttempt !== null;

        if(!$minigameAttempt){
            $minigameAttempt = $this->minigameService->createMinigameAttempt($dto->minigameId, $userId);
        }

        $crosswordResults = new Collection();
        $hasAnswer = $this->minigameService->hasAnswers($minigameAttempt->id);

        foreach($dto->wordAnswers as $wordAnswer){
            $isCorrect = $this->crosswordService->validateCrosswordAnswer($wordAnswer->wordId, $wordAnswer->answerText);

            if(!$isCorrect){
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect answer for Crossword',
                    'data' => (object) [
                        'incorrectWordId' => $wordAnswer->wordId,
                        'incorrectAnswerText' => $wordAnswer->answerText
                    ]
                ]);
            }
        }

        foreach($dto->wordAnswers as $wordAnswer){
            $crosswordResult = $hasAnswer
                ? $this->crosswordService->updateCrosswordAnswer($minigameAttempt->id, $wordAnswer->wordId, $wordAnswer->answerText, 0)
                : $this->crosswordService->createCrosswordAnswer($minigameAttempt->id, $wordAnswer->wordId, $wordAnswer->answerText, 0);

            $crosswordResults->push((object) $crosswordResult);
        }

        $totalPoint = $this->minigameService->getMinigameMaximumPoint($dto->minigameId);

        if (!$isCompleted || $minigameAttempt->total_point != $totalPoint) {
            $minigameAttempt->total_point = $totalPoint;
            $minigameAttempt->save();
    
            $this->pointService->getPointFromMinigame($userId, $minigameAttempt);
            $this->minigameService->setMinigameAttemptStatus($dto->minigameId, $userId, $totalPoint);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Minigame submitted successfully.'
        ]);
    }

    public function submitDrumPuzzle(Request $request)
    {
        $dto = new SubmitDrumPuzzleDTO($request);
        $userId = config('constants.default_user_id');

        if(!$this->minigameService->findMinigame($dto->minigameId)){
            return response()->json(['success' => false, 'message' => 'Minigame not found']);
        }

        $minigameAttempt = $this->minigameService->findMinigameAttempt($dto->minigameId, $userId);
        $isCompleted = $minigameAttempt !== null;

        if(!$minigameAttempt){
            $minigameAttempt = $this->minigameService->createMinigameAttempt($dto->minigameId, $userId);
        }

        $hasAnswer = $this->minigameService->hasAnswers($minigameAttempt->id);

        $drumPuzzleResult = $hasAnswer
            ? $this->drumPuzzleService->updateDrumPuzzleAnswer($minigameAttempt->id, $dto->point, $dto->patternAnswer)
            : $this->drumPuzzleService->createDrumPuzzleAnswer($minigameAttempt->id, $dto->point, $dto->patternAnswer);

        if (!$isCompleted || $minigameAttempt->total_point != $dto->point) {
            $minigameAttempt->total_point = $dto->point;
            $minigameAttempt->save();
    
            $this->pointService->getPointFromMinigame($userId, $minigameAttempt);
            $this->minigameService->setMinigameAttemptStatus($dto->minigameId, $userId, $dto->point);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Minigame submitted successfully.'
        ]);
    }
}
