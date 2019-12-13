<?php

namespace App\ConfigProject;

class Constants
{
    //-System
    const LANGUAGE_EN = 'en';
    const LANGUAGE_DE = 'de';
    const LANGUAGES = [
        0 => self::LANGUAGE_EN,
        1 => self::LANGUAGE_DE,
    ];
    const PAGINATE_PER_PAGE = 15;
    //-User
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_CLIENT = 'client';
    const ROLES = [
        1 => self::ROLE_ADMIN,
        2 => self::ROLE_MODERATOR,
        3 => self::ROLE_CLIENT,
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';
    const STATUSES = [
        0 => self::STATUS_BLOCK,
        1 => self::STATUS_ACTIVE,
    ];

    const TYPE_EMPLOYER = 'employer';
    const TYPE_SEEKER = 'seeker';
    const TYPES = [
        0 => self::TYPE_EMPLOYER,
        1 => self::TYPE_SEEKER,
    ];

    const VERIFY_EMAIL = 'email';
    const VERIFY_PHONE = 'phone';
    const VERIFY_SOCIAL = 'social';
    const VERIFIES = [
        0 => self::VERIFY_EMAIL,
        1 => self::VERIFY_PHONE,
        2 => self::VERIFY_SOCIAL,
    ];

    const SEX_MAN = 'employer';
    const SEX_WOMAN = 'seeker';
    const SEX = [
        0 => self::SEX_MAN,
        1 => self::SEX_WOMAN,
    ];
}
