<?php

namespace App\Services;


use App\Models\User;


class LeaderboardService
{

    public function getFromClearTime(string $userId){
        $topUsers = User::whereNotNull('completion_date')
            ->orderBy('completion_date', 'asc')
            ->orderBy('total_point', 'desc')
            ->take(15)
            ->get();
            
        $currentUser = User::findOrFail($userId);

        $topUsers = $topUsers->map(function ($user, $index) {
            $user->rank = $index + 1;
            return $user;
        });
        
        $currentUser->rank = $currentUser->calculateRankByClearTime();

        return collect([
            'topUsers' => $topUsers,
            'currentUser' => $currentUser,
        ]);
    }

    public function getFromPoint(string $userId)
    {
        $topUsers = User::orderBy('total_point', 'desc')
            ->orderBy('completion_date', 'asc')
            ->take(15)
            ->get();
    
        $currentUser = User::findOrFail($userId);

        $topUsers = $this->calculateUsersRankByPoint($topUsers);

        $currentUser->rank = $currentUser->calculateRankByPoint();

        return collect([
            'topUsers' => $topUsers,
            'currentUser' => $currentUser,
        ]);
    }

    public function getFromCrossword(string $userId){
        
    }

    private function calculateUsersRankByPoint($users)
    {
        $users = $this->sortUsersByPointAndCompletionDate($users);
        return $this->assignRanksToUsers($users);
    }
    
    private function sortUsersByPointAndCompletionDate($users)
    {
        return $users->sortBy(function ($user) {
            return [
                -$user->total_point, // Negative for descending order
                is_null($user->completion_date) ? 1 : 0, // 0 for non-null, 1 for null
            ];
        })->values();
    }
    
    private function assignRanksToUsers($users)
    {
        $currentRank = 1;
        $currentRankCount = 0;
        $previousTotalPoint = null;
        $previousCompletionDate = null;
    
        return $users->map(function ($user) use (
            &$currentRank,
            &$currentRankCount,
            &$previousTotalPoint,
            &$previousCompletionDate,
        ) {
            if (
                $user->total_point !== $previousTotalPoint ||
                $user->completion_date !== $previousCompletionDate
            ) {
                $currentRank += $currentRankCount; // Increment rank by group size
                $currentRankCount = 1; // Reset group size
            } else {
                $currentRankCount++;
            }
    
            $user->rank = $currentRank;
    
            $previousTotalPoint = $user->total_point;
            $previousCompletionDate = $user->completion_date;
    
            return $user;
        });
    }
}
