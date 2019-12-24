<?php

namespace App\Http\Resources\Location;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'name' => $this->getName(),
            'long_name' => $this->getLongName(),
            'place_id' => $this->getPlaceId(),
            'lat' => $this->Lat(),
            'lng' => $this->Lng(),
        ];
    }
}
