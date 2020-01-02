<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-getters
    public function getId() { return $this->id; }

}
