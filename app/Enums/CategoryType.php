<?php

namespace App\Enums;

class CategoryType
{
    const CATEGORY = 'category';
    const AUTHOR = 'author';
    const TAG = 'tag';
    const NAV_MENU = 'nav_menu';

    public static function toArray()
    {
        return [
            self::CATEGORY,
            self::AUTHOR,
            self::TAG,
            self::NAV_MENU,
        ];
    }
}
