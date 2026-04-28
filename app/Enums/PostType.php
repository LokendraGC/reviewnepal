<?php

namespace App\Enums;

class PostType
{
    const POST = 'post';
    const PAGE = 'page';
    const TEAM = 'team';
    const POSTNE = 'post_ne';

    public static function toArray()
    {
        return [
            self::POST,
            self::PAGE,
            self::TEAM,
            self::POSTNE,
        ];
    }
}
