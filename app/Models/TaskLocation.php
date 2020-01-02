<?php

namespace App\Models;

class TaskLocation extends BaseModel
{
    //-data
    protected $table = 'task_locations';

    protected $fillable = [
        'task_id',
        'name',
        'long_name',
        'place_id',
        'lat',
        'lng',
    ];

    //-getters
    public function getName() { return $this->name; }
    public function getLongName() { return $this->long_name; }
    public function getPlaceId() { return $this->place_id; }
    public function getLat() { return $this->lat; }
    public function getLng() { return $this->lng; }

    //-relations
    public function _task()
    {
        return $this->belongsTo(Task::class);
    }
}
