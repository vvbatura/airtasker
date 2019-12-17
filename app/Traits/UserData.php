<?php

namespace App\Traits;

trait UserData
{
    public static function scopeRelations($query)
    {
        return $query->with([
            '_socials',
            '_profile',
            '_location',
            '_skills',
            '_tasks',
        ]);
    }

    public static function scopeBuildFields($query)
    {
        return $query;
    }
}
