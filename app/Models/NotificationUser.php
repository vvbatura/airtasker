<?php

namespace App\Models;

use App\User;

class NotificationUser extends BaseModel
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

    //-getters
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
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function _action()
    {
        return $this->hasOne(NotificationAction::class, 'id', 'action_id');
    }
}
