<?php

namespace App\Constants;

class SystemConstants
{

    const LANGUAGE_EN = 'en';
    const LANGUAGE_DE = 'de';
    const LANGUAGES = [
        0 => self::LANGUAGE_EN, 1 => self::LANGUAGE_DE,
    ];
    const PAGINATE_PER_PAGE = 15;

    const SAVE_fILE_EXTENSIONS = [
        'jpg', 'png', 'pdf', 'doc', 'docx', 'txt',
    ];

}
