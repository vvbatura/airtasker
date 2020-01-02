<?php

namespace App\Models;

use App\User;

class UserSkill extends BaseModel
{
    //-data
    protected $table = 'user_skills';

    protected $fillable = [
        'user_id',
        'good_at',
        'get_around',
        'languages',
        'qualifications',
        'experience',
    ];

    protected $casts = [
        'get_around' => 'array',
    ];

    //-getters
    public function getGoodAt() { return $this->good_at; }
    public function getGetAround() { return $this->get_around; }
    public function getLanguages() { return $this->languages; }
    public function getQualifications() { return $this->qualifications; }
    public function getExperience() { return $this->experience; }

    //-relations
    public function _user()
    {
        return $this->hasOne(User::class);
    }
}
