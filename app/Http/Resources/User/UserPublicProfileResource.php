<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPublicProfileResource extends JsonResource
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
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'address' => $this->getAddress(),
            'tag_line' => $this->getTagLinePhone(),
            'birth_date' => $this->getBirthDay(),
            'sex' => $this->getSex(),
            'abn' => $this->getAbn(),
            'description' => $this->getDescription(),
            'type' => $this->getType(),
            'image' => $this->getImagePath(),
            'roles' => RoleResource::collection($this->roles),
            'location' => new LocationResource($this->_location),
            'skills' => new UserSkillResource($this->_skills),
            'tasks' => $this->_tasks,
        ];
    }
}
