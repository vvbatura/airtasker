<?php

namespace App\Traits;

use App\Constants\SystemConstants;
use Illuminate\Http\Request;

trait TableData
{
    public static function getLocaleFields()
    {
        if (isset(self::$localeFields) && is_array(self::$localeFields)) {
            return self::$localeFields;
        }
        return [];
    }

    public static function getSortSearchFields()
    {
        if (isset(self::$sortSearchFields) && is_array(self::$sortSearchFields)) {
            return self::$sortSearchFields;
        }
        return [];
    }

    public function scopeSearch($query, Request $request)
    {
        $searchField = $request->get('search_field', false);
        $searchQuery = $request->get('search_query', false);
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);
        $searchFields = self::getSortSearchFields();

        if (!$searchQuery) {
            return $query;
        }
        $localeFields = self::getLocaleFields();
        if ($searchField && in_array($searchQuery, $searchFields)) {
            if (in_array($searchField, $localeFields)) {
                $searchField = $searchField . "->$locale";
            }
            $query = $query->where($searchField, 'LIKE', "%$searchQuery%");

        } else {
            $query = $query->where(function ($query) use ($searchQuery, $searchFields, $localeFields, $locale) {
                $firstKey = array_key_first($searchFields);
                foreach ($searchFields as $key => $field) {
                    if (in_array($field, $localeFields)) {
                        $field = $field . "->$locale";
                    }
                    if ($key === $firstKey) {
                        $query = $query->where($field, 'LIKE', "%$searchQuery%");
                    } else {
                        $query = $query->orWhere($field, 'LIKE', "%$searchQuery%");
                    }
                }
            });
        }

        return $query;
    }

    public static function scopeSort($query, Request $request)
    {
        $orderField = $request->get('order_field', 'date');
        $orderType = $request->get('order_type',  'asc');
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);
        $sortFields = self::getSortSearchFields();
        $localeFields = self::getLocaleFields();

        if (in_array($orderField, $sortFields)) {
            if (in_array($orderField, $localeFields)) {
                $orderField = $orderField . "->$locale";
            }
            $query = $query->orderBy($orderField, $orderType);
        }

        return $query;
    }
}
