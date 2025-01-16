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
    public function getUser(Request $request)
    {
        try {
            $user = $this->userService->getUser($request->user()->id);

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

    public function resetUser(Request $request) {
        try {
            $user = $this->userService->getUser($request->user()->id);

            if (!$user){
                $response = response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            } else {
                $this->userService->resetUser($user->id);
                $response = response()->json([
                    'success' => true,
                    'message' => 'Reset user data success',
                ]);
            }
    
            return $response;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request
        }
    }

}
