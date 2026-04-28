<?php

namespace App\Helpers;

use App\Models\Post;

class isHomePage
{
    public static function check()
    {
        $pageId = 1;
        $post = Post::findOrFail($pageId);
        $postMeta = $post->GetAllMetaData();
        if ($postMeta['page_template'] === 'home') {
            return $postMeta;
        }
        return null;
    }
}
