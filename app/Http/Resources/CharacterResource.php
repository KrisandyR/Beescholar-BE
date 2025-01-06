<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->character_name,
            'image' => $this->character_image,
            'description' => $this->description,
            'roles' => $this->roles,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'gender' => $this->gender,
        ];
    }
}
