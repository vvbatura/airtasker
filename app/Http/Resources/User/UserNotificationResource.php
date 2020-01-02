<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
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
            'user_id' => $this->getUserId(),
            'action_id' => $this->getActionId(),
            'action' => $this->getActionName(),
            'email' => $this->getEmail(),
            'sms' => $this->getSms(),
            'push' => $this->getPush(),
        ];
    }
}
