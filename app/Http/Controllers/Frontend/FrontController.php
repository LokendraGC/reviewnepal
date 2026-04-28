<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\Setting;
use App\Http\Controllers\Controller;


class FrontController extends Controller
{
    public function index()
    {
        $pageId = 1;
        $post = Post::findOrFail($pageId);
        $postMeta = $post->GetAllMetaData();

        $pages = Post::query()
            ->where('post_type', 'page')
            ->where('post_status', 'publish')
            ->orderBy('menu_order')
            ->latest()
            ->get();

        // $page_id = 4;

        // $media_page = Post::query()->where('id', $page_id)->where('post_status', 'publish')->first();

        // $media_page_meta = $media_page ? $media_page->GetAllMetaData() : null;


        return view('frontend.front', [
            'post' => $post,
            'postMeta' => $postMeta,
            'pages' => $pages
        ]);
    }
}
