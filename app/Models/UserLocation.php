<?php

namespace App\Models;

use App\User;

class UserLocation extends BaseModel
{
    //-data
    protected $table = 'user_locations';

    protected $fillable = [
        'user_id',
        'name',
        'long_name',
        'place_id',
        'lat',
        'lng',
    ];

    //-getters
    public function getName() { return $this->name; }
    public function getLongName() { return $this->long_name; }
    public function getPlaceId() { return $this->place_id; }
    public function getLat() { return $this->lat; }
    public function getLng() { return $this->lng; }

    //-relations
    public function _user()
    {
        return $this->belongsTo(User::class);
    }
}
