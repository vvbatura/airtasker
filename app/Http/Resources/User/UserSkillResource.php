<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'good_at' => $this->getGoodAt(),
            'get_around' => $this->getGetAround(),
            'languages' => $this->getLanguages(),
            'qualifications' => $this->getQualifications(),
            'experience' => $this->getExperience(),
        ];
    }
}
