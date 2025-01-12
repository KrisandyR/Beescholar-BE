<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/characters/{campusName}', [CharacterController::class, 'getCharactersBasedOnCampus']);
Route::get('/activity/{roomId}', [ActivityController::class, 'getActivityFromRoom']);
Route::get('/campus/{userId}', [CampusController::class, 'getUnlockedCampus']);
Route::get('/room/{campusId}', [RoomController::class, 'getRoomFromCampus']);
Route::get('/minigame/{minigameId}', [MinigameController::class, 'getMinigame']);
Route::get('/scene/{sceneId}', [SceneController::class, 'getScene']);
Route::post('/process_scene/{sceneId}', [SceneController::class, 'processScene']);
Route::get('/user/{userId}', [UserController::class, 'getUser']);
Route::post('/submit_quiz', [MinigameController::class, 'submitQuiz']);

Route::prefix('leaderboard')->group(function () {
    Route::get('stats/{userId}', [LeaderboardController::class, 'getUserProgress']);
    Route::get('{leaderboardType}/{userId}', [LeaderboardController::class, 'getLeaderboard']);
});
