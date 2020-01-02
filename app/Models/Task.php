<?php

namespace App\Models;

use App\User;

class Task extends BaseModel
{
    //-data
    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'title',
        'details',
        'date',
        'price_total',
        'price_hourly',
        'status',
    ];

    //-getters
    public function getTitle() { return $this->title; }
    public function getDetails() { return $this->details; }
    public function getDate() { return $this->date; }
    public function getPriceTotal() { return $this->price_total; }
    public function getPriceHourly() { return $this->price_hourly; }
    public function getStatus() { return $this->status; }
    public function getUserId() { return $this->user_id; }
    public function getUserName() { return $this->_user ? $this->_user->getName() : null; }
    public function getLocationName() { return $this->_location ? $this->_location->getName() : null; }
    public function getLocationLongName() { return $this->_location ? $this->_location->getLongName() : null; }
    public function getCreatedAt() { return $this->created_at; }

    //-relations
    public function _user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function _location()
    {
        return $this->hasOne(TaskLocation::class);
    }
    public function _notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
