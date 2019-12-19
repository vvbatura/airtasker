<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //-data
    protected $table = 'locations';

    protected $fillable = [
        'user_id',
        'name',
        'long_name',
        'google_place_id',
        'lat',
        'lng',
    ];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getShortName() { return $this->short_name; }
    public function getGooglePlaceId() { return $this->google_place_id; }
    public function getLat() { return $this->lat; }
    public function getLng() { return $this->lng; }

    //-relations
    public function _user()
    {
        return $this->belongsTo(User::class);
    }
}
