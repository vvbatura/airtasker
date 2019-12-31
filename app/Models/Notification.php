<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    //-data
    protected $table = 'notifications';

    protected $fillable = [
        'data',
        'read_at',
    ];
    protected $casts = [
        'data' => 'array',
    ];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-getters
    public function getId() { return $this->id; }
    public function getData() { return $this->data; }
    public function getReadAt() { return $this->read_at; }
    public function getActionTitle() { return $this->_action ? $this->_action->getTitle() : null; }

    //-relations
    public function _action()
    {
        return $this->hasOne(NotificationAction::class, 'name', 'data->action');
    }
}
