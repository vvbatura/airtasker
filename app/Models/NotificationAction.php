<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationAction extends Model
{
    use SoftDeletes;
    //-data
    protected $table = 'notification_actions';

    protected $fillable = [
        'title',
    ];
    protected $casts = [
        'title' => 'array',
    ];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }

    //-relations
    public function _users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'action_id', 'user_id');
    }
}
