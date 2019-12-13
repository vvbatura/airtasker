<?php

namespace App;

use App\ConfigProject\Constants;
use App\Models\AuthProvider;
use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    //-data
    protected $fillable = [
        'first_name', 'last_name',
        'email', 'phone', 'password',
        'type', 'status',
        'verify_token', 'verify_type', 'verified_at',
    ];

    protected $casts = [
        'type' => 'array',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verify_token',
    ];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }
    public function setPasswordAttribute($password) { $this->attributes['password'] = bcrypt($password); }

    //-methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function isVerifiedAccount()
    {
        return ! is_null($this->verified_at);
    }
    public function isActiveAccount()
    {
        return $this->status == Constants::STATUS_ACTIVE;
    }
    public static function makeHash() {
        return md5(uniqid());
    }

    //-relations
    public function _profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function _socials()
    {
        return $this->hasMany(AuthProvider::class);
    }
}
