<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Helpers\LanguageHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class FrontController extends Controller
{
    public function index()
    {
        $pageId = 1;
        $post = Post::findOrFail($pageId);
        $postMeta = $post->GetAllMetaData();
        $language = LanguageHelper::getUserLanguage();
        $post_type = $language == 'en' ? 'post' : 'post_ne';

        $number_of_news_to_show_in_banner = $postMeta['number_of_news_to_show_in_banner'] ?? 1;
        $category_id_left_second = $postMeta['category_id_left_second'];
        $category_id_right_second = $postMeta['category_id_right_second'];
        $category_id_third = $postMeta['category_id_third'];
        $category_id_fourth = $postMeta['category_id_fourth'];
        $category_id_left_fifth = $postMeta['category_id_left_fifth'];
        $category_id_middle_fifth = $postMeta['category_id_middle_fifth'];
        $category_id_right_fifth = $postMeta['category_id_right_fifth'];
        $category_id_sixth = $postMeta['category_id_sixth'];
        $category_id_seventh = $postMeta['category_id_seventh'];


        // RECENT POSTS
        $recent_posts = Post::where('post_type', $post_type)->where('post_status', 'publish')
        ->latest()->take($number_of_news_to_show_in_banner)->get();

        // LEFT SECOND CATEGORY
        $left_second_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc' )->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_left_second)->first();

        // RIGHT SECOND CATEGORY
        $right_second_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_right_second)->first();

        // THIRD CATEGORY
        $third_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_third)->first();

        // FOURTH CATEGORY
        $fourth_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_fourth)->first();

        // FIFTH LEFT CATEGORY
        $fifth_left_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_left_fifth)->first();

        // FIFTH MIDDLE CATEGORY
        $fifth_middle_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_middle_fifth)->first();

        // FIFTH RIGHT CATEGORY
        $fifth_right_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_right_fifth)->first();

        // SIXTH CATEGORY
        $sixth_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_sixth)->first();

        // SEVENTH CATEGORY
        $seventh_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_seventh)->first();
       
        // $left_second_posts = Post::where('post_type', $post_type)->where('post_status', 'publish')
        // ->whereHas('categories', fn($q) => $q->where('categories.id', $category_id_left_second))
        // ->latest()->get();

        // $right_second_posts = Post::where('post_type', $post_type)->where('post_status', 'publish')
        // ->whereHas('categories', fn($q) => $q->where('categories.id', $category_id_right_second))
        // ->latest()->get();

        $user = Auth::user();

        return view('frontend.front', [
            'post' => $post,
            'postMeta' => $postMeta,
            'recent_posts' => $recent_posts,
            'left_second_posts' => $left_second_cat,
            'right_second_posts' => $right_second_cat,
            'third_cat' => $third_cat,
            'fourth_cat' => $fourth_cat,
            'fifth_left_cat' => $fifth_left_cat,
            'fifth_middle_cat' => $fifth_middle_cat,
            'fifth_right_cat' => $fifth_right_cat,
            'sixth_cat' => $sixth_cat,
            'seventh_cat' => $seventh_cat,
            'user' => $user,
            'language' => $language,
        ]);
    }
}
