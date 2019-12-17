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
            'short_name' => $this->getShortName(),
            'google_place_id' => $this->getGooglePlaceId(),
            'lat' => $this->Lat(),
            'lng' => $this->Lng(),
        ];
    }
}
