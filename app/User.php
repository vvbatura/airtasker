<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_CLIENT = 'client';
    const ROLES = [
        1 => self::ROLE_ADMIN,
        2 => self::ROLE_MODERATOR,
        3 => self::ROLE_CLIENT,
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';
    const STATUSES = [
        0 => self::STATUS_BLOCK,
        1 => self::STATUS_ACTIVE,
    ];

    const TYPE_EMPLOYER = 'employer';
    const TYPE_SEEKER = 'seeker';
    const TYPES = [
        0 => self::TYPE_EMPLOYER,
        1 => self::TYPE_SEEKER,
    ];

    const VERIFY_EMAIL = 'email';
    const VERIFY_PHONE = 'phone';
    const VERIFIES = [
        0 => self::VERIFY_EMAIL,
        1 => self::VERIFY_PHONE,
    ];

    const SEX_MAN = 'employer';
    const SEX_WOMAN = 'seeker';
    const SEX = [
        0 => self::SEX_MAN,
        1 => self::SEX_WOMAN,
    ];

    protected $fillable = [
        'first_name', 'last_name',
        'email', 'phone', 'password',
        'type', 'status',
        'verify_token', 'verify_type', 'verified_at',
    ];

    protected $dates = [
        'verified_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verify_token',
    ];

    //-setters
    public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at'] = $date;
    }
    public function setUpdatedAtAttribute($date)
    {
        $this->attributes['updated_at'] = $date;
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function setTypeAttribute($type)
    {
        $this->attributes['type'] = json_encode($type);
    }
    //-methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    /*public function generateVerifyToken()
    {
        do {
            $verifyToken = Str::random(15);
            $this->setAttribute('verify_token', $verifyToken);
        } while (!is_null(self::where('verify_token', $verifyToken)->first()));
    }*/
    public function isVerifiedAccount()
    {
        return ! is_null($this->verified_at);
    }
    public function isActiveAccount()
    {
        return $this->status == self::STATUS_ACTIVE;
    }
    public static function makeHash() {
        return md5(uniqid());
    }
    //-relations
    public function _profile()
    {
        return $this->hasOne('App\Models\Profile');
    }
}
