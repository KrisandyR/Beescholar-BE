<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    //
    public function getUser(string $userId)
    {
        try {
            $user = $this->userService->getUser($userId);

            if (!$user){
                $response = response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            } else {
                $response = response()->json([
                    'success' => true,
                    'data' => new UserResource($user),
                ]);
            }
    
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }

}
