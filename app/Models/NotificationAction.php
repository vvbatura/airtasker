<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationAction extends BaseModel
{
    use SoftDeletes;
    //-data
    protected $table = 'notification_actions';

    protected $fillable = [
        'name',
        'title',
    ];
    protected $casts = [
        'title' => 'array',
    ];

    //-getters
    public function getName() { return $this->name; }
    public function getTitle() { return $this->title; }

    //-relations
    public function _users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'action_id', 'user_id');
    }
}
