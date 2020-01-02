<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends BaseModel
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

    //-getters
    public function getData() { return $this->data; }
    public function getReadAt() { return $this->read_at; }
    public function getActionTitle() { return $this->_action ? $this->_action->getTitle() : null; }

    //-relations
    public function _action()
    {
        return $this->hasOne(NotificationAction::class, 'name', 'data->action');
    }
}
