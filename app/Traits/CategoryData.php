<?php

namespace App\Traits;

trait CategoryData
{
    public static function scopeRelations($query)
    {
        return $query->with([
            '_tasks',
        ]);
    }

    public static function scopeBuildFields($query)
    {
        return $query;
    }
}
