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

    /*const VERIFY_EMAIL = 'email';
    const VERIFY_PHONE = 'phone';
    const VERIFY_SOCIAL = 'social';
    const VERIFIES = [
        0 => self::VERIFY_EMAIL,
        1 => self::VERIFY_PHONE,
        2 => self::VERIFY_SOCIAL,
    ];*/

    const SEX_MAN = 'employer';
    const SEX_WOMAN = 'seeker';
    const SEX = [
        0 => self::SEX_MAN,
        1 => self::SEX_WOMAN,
    ];

    const SKILL_GET_AROUND_BICYCLE = 'bicycle';
    const SKILL_GET_AROUND_CAR = 'car';
    const SKILL_GET_AROUND_ONLINE = 'online';
    const SKILL_GET_AROUND_SCOOTER = 'scooter';
    const SKILL_GET_AROUND_TRUCK = 'truck';
    const SKILL_GET_AROUND_WALK = 'walk';
    const SKILLS_GET_AROUND = [
        1 => self::SKILL_GET_AROUND_BICYCLE,
        2 => self::SKILL_GET_AROUND_CAR,
        3 => self::SKILL_GET_AROUND_ONLINE,
        4 => self::SKILL_GET_AROUND_SCOOTER,
        5 => self::SKILL_GET_AROUND_TRUCK,
        6 => self::SKILL_GET_AROUND_WALK,
    ];
}
