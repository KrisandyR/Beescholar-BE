<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'role' => $this->role,
            'userCode' => $this->user_code,
            'academicCareer' => $this->academic_career,
            'totalPoint' => $this->total_point,
            'completionDate' => $this->completion_date,
            'semester' => $this->semester,
            'gender' => $this->gender,
            'email' => $this->email,
            'profilePicture' => $this->profile_picture
        ];
    }
}
