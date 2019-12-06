<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = [
        'user_id',
        'birth_date',
        'address',
        'sex',
        'teg_line',
        'abn',
        'description',
    ];

    protected $casts = ['birth_date' => 'datetime'];

    //-setters
    public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at'] = $date;
    }
    public function setUpdatedAtAttribute($date)
    {
        $this->attributes['updated_at'] = $date;
    }

    //-relations
    public function _user()
    {
        return $this->belongsTo('App\User');
    }

}
