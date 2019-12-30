<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    //-data
    protected $table = 'notification_user';

    protected $fillable = [
        'user_id',
        'action_id',
        'email',
        'sms',
        'push',
    ];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-getters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getSms() { return $this->sms; }
    public function getPush() { return $this->push; }
    public function getUserId() { return $this->user_id; }
    public function getUserName() { return $this->_user ? $this->_user->getName() : null; }
    public function getActionId() { return $this->action_id; }
    public function getActionName() { return $this->_action ? $this->_action->getTitle() : null; }

    //-relations
    public function _user()
    {
        return $this->belongsTo(User::class);
    }
    public function _action()
    {
        return $this->belongsTo(NotificationAction::class, 'id', 'action_id');
    }
}
