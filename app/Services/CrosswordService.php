<?php

namespace App\Services;

use App\Models\Campus;
use App\Models\CampusProgress;
use App\Models\Crossword;
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
}
