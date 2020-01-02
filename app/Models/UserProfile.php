<?php

namespace App\Models;

use App\User;

class UserProfile extends BaseModel
{

    //-data
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'birth_date',
        'sex',
        'tag_line',
        'abn',
        'description',
    ];

    protected $casts = ['birth_date' => 'datetime'];

    //-relations
    public function _user()
    {
        return $this->belongsTo(User::class);
    }

}
