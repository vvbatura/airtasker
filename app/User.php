<?php

namespace App;

use App\Constants\UserConstants;
use App\Models\AuthProvider;
use App\Models\Location;
use App\Models\NotificationAction;
use App\Models\Profile;
use App\Models\Skill;
use App\Traits\TableData;
use App\Traits\UserData;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use TableData, UserData;
    use HasMediaTrait;

    //-data
    protected $fillable = [
        'first_name', 'last_name',
        'email', 'phone', 'password',
        'type', 'status',
        'verify_token', 'verified_at',
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
    public function setPasswordAttribute($password) { $this->attributes['password'] = Hash::make($password); }

    //-getters
    public function getId() { return $this->id; }
    public function getFirstName() { return $this->first_name; }
    public function getLastName() { return $this->last_name; }
    public function getName() { return $this->first_name . ' ' . $this->last_name; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getAddress() { return $this->_address ? $this->_address->title : null; }
    public function getTagLinePhone() { return $this->_profile ? $this->_profile->tag_line : null; }
    public function getBirthDay() { return $this->_profile ? $this->_profile->birth_day : null; }
    public function getSex() { return $this->_profile ? $this->_profile->sex : null; }
    public function getAbn() { return $this->_profile ? $this->_profile->abn : null; }
    public function getDescription() { return $this->_profile ? $this->_profile->description : null; }
    public function getType() { return $this->type; }
    public function getImagePath()
    {
        if ($this->hasMedia($this->table)) {
            $image = $this->getFirstMedia($this->table);
            return $image->getUrl();
        }
        return null;
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
    public function isVerifiedAccount()
    {
        return ! is_null($this->verified_at);
    }
    public function isActiveAccount()
    {
        return $this->status == UserConstants::STATUS_ACTIVE;
    }
    public static function makeHash() {
        return md5(uniqid());
    }
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }

    //-relations
    public function _socials()
    {
        return $this->hasMany(AuthProvider::class);
    }
    public function _profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function _location()
    {
        return $this->hasOne(Location::class);
    }
    public function _skills()
    {
        return $this->hasMany(Skill::class);
    }
    public function _actions()
    {
        return $this->belongsToMany(NotificationAction::class, 'notification_user', 'user_id', 'action_id')
            ->withPivot('email', 'sms', 'push');
    }
    public function _tasks()
    {
        //return $this->hasMany(Task::class);
    }
}
