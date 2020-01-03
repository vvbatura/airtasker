<?php

namespace App\Constants;

class TaskConstants
{

    const STATUS_OPENED = 'opened';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETED = 'completed';
    const STATUSES = [
        self::STATUS_OPENED ,self::STATUS_CANCELED, self::STATUS_COMPLETED
    ];

    const TYPE_ALL = 'all';
    const TYPE_POSTED = 'posted';
    const TYPE_DRAFT = 'draft';
    const TYPE_ASSIGNED = 'assigned';
    const TYPE_NOT_ASSIGNED = 'not-assigned';
    const TYPE_OFFERS = 'offers';
    const TYPE_COMPLETED = 'completed';
    const TYPES = [
        self::TYPE_ALL ,self::TYPE_POSTED, self::TYPE_DRAFT, self::TYPE_ASSIGNED, self::TYPE_NOT_ASSIGNED, self::TYPE_OFFERS, self::TYPE_COMPLETED
    ];

    const PLACE_ALL = 'all';
    const PLACE_LOCATION = 'location';
    const PLACE_REMOTE = 'remote';
    const PLACES = [
        self::PLACE_ALL ,self::PLACE_LOCATION
    ];
}
