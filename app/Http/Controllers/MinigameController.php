<?php

namespace App\Http\Controllers;

use App\Http\DTOs\SubmitQuizDTO;
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

    public function __construct(MinigameService $minigameService, QuizService $quizService, PointService $pointService)
    {
        $this->minigameService = $minigameService;
        $this->quizService = $quizService;
        $this->pointService = $pointService;
    }
    public function getMinigame(string $minigameId)
    {
        // try{
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
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        // }
    }

    public function submitQuiz(Request $request)
    {
        $dto = new SubmitQuizDTO($request);
        $userId = config('constants.default_user_id');

        if(!$this->minigameService->findMinigame($dto->minigameId)){
            return response()->json(['success' => false, 'message' => 'Minigame not found']);
        }

        $minigameAttempt = $this->minigameService->findMinigameAttempt($dto->minigameId, $userId);
        $isCompleted = true;

        if(!$minigameAttempt){
            $minigameAttempt = $this->minigameService->createMinigameAttempt($dto->minigameId, $userId);
            $isCompleted = false;
        }
        
        $quizChoiceResults = new Collection();
        $quizStepsResults = new Collection();
        
        $totalPoint = 0;

        $hasAnswer = $this->quizService->hasAnswers($minigameAttempt->id);

        dump($hasAnswer);

        foreach ($dto->quizChoiceAnswers as $choiceAnswer) {
            $isCorrect = $this->quizService->validateQuizMultipleChoiceAnswer($choiceAnswer->choiceId);
            $answerPoint = 0;
            
            if($isCorrect){
                $answerPoint = $this->quizService->getQuizQuestionPoint($choiceAnswer->questionId);
                $totalPoint += $answerPoint;
            }

            if ($hasAnswer) {
                $quizMultipleChoiceAnswer = $this->quizService->updateQuizMultipleChoiceAnswer(
                    $minigameAttempt->id, $choiceAnswer->questionId, $choiceAnswer->choiceId, $answerPoint, $isCorrect
                );
            } else {
                $quizMultipleChoiceAnswer = $this->quizService->createQuizMultipleChoiceAnswer(
                    $minigameAttempt->id, $choiceAnswer->questionId, $choiceAnswer->choiceId, $answerPoint, $isCorrect
                );
            }

            $quizChoiceResults->push((object) [
                'choiceAnswer' => $choiceAnswer,
                'quizMultipleChoiceAnswer' => $quizMultipleChoiceAnswer,
            ]);

        }

        foreach ($dto->quizStepAnswers as $stepAnswer) {
            $isCorrect = $this->quizService->validateQuizOrderStepsAnswer(
                $stepAnswer->stepIds, $stepAnswer->questionId
            );
            $answerPoint = 0;

            if($isCorrect){
                $answerPoint = $this->quizService->getQuizQuestionPoint($stepAnswer->questionId);
                $totalPoint += $answerPoint;
            }

            if ($hasAnswer) {
                $quizOrderStepsAnswer = $this->quizService->updateQuizOrderStepsAnswer(
                    $minigameAttempt->id, $stepAnswer->questionId, $stepAnswer->stepIds, $answerPoint, $isCorrect
                );
            } else {
                $quizOrderStepsAnswer = $this->quizService->createQuizOrderStepsAnswer(
                    $minigameAttempt->id, $stepAnswer->questionId, $stepAnswer->stepIds, $answerPoint, $isCorrect
                );
            }
            
            $quizStepsResults->push((object) [
                'stepAnswer' => $stepAnswer,
                'quizOrderStepsAnswer' => $quizOrderStepsAnswer,
            ]);

        }

        if (!$isCompleted || $minigameAttempt->total_point != $totalPoint){
            $minigameAttempt->total_point = $totalPoint;
            $minigameAttempt->save();

            $this->pointService->getPointFromMinigame($userId, $minigameAttempt);
        }

        return response()->json(['success' => true, 'message' => 'Minigame submitted successfully.']);
    }

    public function submitCrossword()
    {
        
    }

    public function submitFollowTheDrum()
    {

    }
}
