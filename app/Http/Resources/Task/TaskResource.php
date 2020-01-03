<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->getTitle(),
            'details' => $this->getDetails(),
            'date' => $this->getDate(),
            'price' => $this->getPriceTotal() ? $this->getPriceTotal() : ($this->getPriceHourly() . ' hourly'),
            'created_ad' => $this->getCreatedAt(),
            'status' => $this->getStatus(),
            'user_name' => $this->getUserName(),
            'location_name' => $this->getLocationName(),
            'location_long_name' => $this->getLocationLongName(),
            'location' => new TaskResource($this->_location),
        ];
    }
}
