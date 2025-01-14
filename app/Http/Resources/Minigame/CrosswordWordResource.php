<?php

namespace App\Http\Resources\Minigame;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrosswordWordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'wordId' => $this->id,
            'clue' => $this->clue,
            'direction' => $this->direction,
            'answer' => $this->word_answer,
            'colStartIdx'  => $this->col_start_idx,
            'rowStartIdx'  => $this->row_start_idx,
        ];
    }
}
