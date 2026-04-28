<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        // $posts = Post::where('post_type', 'post')->where('post_status', 'publish')->get();
        $pages = Post::where('slug', '!=', 'home')->where('post_type', 'page')->where('post_status', 'publish')->get();
        $categories = Category::whereType('category')->get();

        // return $categories;

        return response()->view('frontend.sitemap', [
            'pages' => $pages,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
