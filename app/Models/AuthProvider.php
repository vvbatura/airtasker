<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AuthProvider extends Model
{
    protected $table = 'auth_providers';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'access_token',
        'refresh_token',
    ];

    protected $guarded = ['id'];

    protected $hidden = [
        'access_token', 'refresh_token',
    ];

    //-relations
    public function _user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
