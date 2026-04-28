<?php

namespace App\Helpers;

use App\Models\Comment;

class CommentHelper
{
    public static function getModel()
    {
        return new Comment();
    }
}
