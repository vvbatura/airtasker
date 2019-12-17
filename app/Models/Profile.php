<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    //-data
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'birth_date',
        'sex',
        'tag_line',
        'abn',
        'description',
    ];

    protected $casts = ['birth_date' => 'datetime'];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-relations
    public function _user()
    {
        return $this->belongsTo(User::class);
    }

}
