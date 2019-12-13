<?php

namespace App\Models;

use App\Traits\CategoryData;
use App\Traits\TableData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Category extends Model implements HasMedia
{
    use SoftDeletes;
    use TableData, CategoryData;
    use HasMediaTrait;

    //-data
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'description',
    ];
    protected $casts = [
        'title' => 'array',
        'description' => 'array'
    ];

    protected static $sortSearchFields = ['title', 'description', 'created_at'];
    protected static $localeFields = ['title', 'description'];

    //-setters
    public function setCreatedAtAttribute($date) { $this->attributes['created_at'] = $date; }
    public function setUpdatedAtAttribute($date) { $this->attributes['updated_at'] = $date; }

    //-getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->created_at; }
    public function getImagePath()
    {
        if ($this->hasMedia($this->table)) {
            $image = $this->getFirstMedia($this->table);
            return $image->getUrl();
        }
        return null;
    }

    //-relations
    public function _tasks()
    {
        //return $this->hasMany(Task::class);
    }
}
