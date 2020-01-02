<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'data' => $this->getData(),
            'read_at' => $this->getReadAt(),
            'created_at' => $this->created_at,
            'action' => json_decode($this->title),
            'action_id' => $this->action_id,
        ];
    }
}
