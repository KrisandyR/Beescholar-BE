<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MinigameController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SceneController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CharacterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/characters/{campusName}', [CharacterController::class, 'getCharactersBasedOnCampus']);
    Route::get('/activity/{roomId}', [ActivityController::class, 'getActivityFromRoom']);
    Route::get('/campus', [CampusController::class, 'getUnlockedCampus']); // No userId in the route
    Route::get('/room/{campusId}', [RoomController::class, 'getRoomFromCampus']);
    Route::get('/minigame/{minigameId}', [MinigameController::class, 'getMinigame']);
    Route::get('/scene/{sceneId}', [SceneController::class, 'getScene']);
    Route::post('/process_scene/{sceneId}', [SceneController::class, 'processScene']);
    Route::get('/user', [UserController::class, 'getUser']); // No userId in the route
    Route::post('/submit/quiz', [MinigameController::class, 'submitQuiz']);
    Route::post('/submit/crossword', [MinigameController::class, 'submitCrossword']);
    Route::post('/submit/drum_puzzle', [MinigameController::class, 'submitDrumPuzzle']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset_user', [UserController::class, 'resetUser']);


    Route::prefix('leaderboard')->group(function () {
        Route::get('stats', [LeaderboardController::class, 'getUserProgress']); // No userId in the route
        Route::get('{leaderboardType}', [LeaderboardController::class, 'getLeaderboard']); // No userId in the route
    });
});
