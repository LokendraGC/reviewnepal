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

        $category_id_left_second = $postMeta['category_id_left_second'];
        $category_id_right_second = $postMeta['category_id_right_second'];
        $number_of_news_to_show_in_banner = $postMeta['number_of_news_to_show_in_banner'] ?? 1;
        $category_id_fifth = $postMeta['category_id_fifth'];
        $category_id_fourth = $postMeta['category_id_fourth'];
        $category_id_left_fifth = $postMeta['category_id_left_fifth'];
        $category_id_middle_fifth = $postMeta['category_id_middle_fifth'];
        $category_id_right_fifth = $postMeta['category_id_right_fifth'];
        $category_id_seventh = $postMeta['category_id_seventh'];
        $category_id_sixth = $postMeta['category_id_sixth'];
        $category_id_third = $postMeta['category_id_third'];

        // $cat = Category::where([ 'id' => $id, 'type' => 'author' ])->firstOrFail();

        // $catMeta = $this->categoryRepository->getMetaDatas($cat);

        // $posts = $cat->posts()->orderBy('created_at', 'desc')->get();

        $left_second_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc' )->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_left_second)->first();

        $right_second_cat = Category::with(['posts' => function($query) use ($post_type) {
            $query->orderBy('created_at', 'desc')->where('post_type', $post_type)->where('post_status', 'publish');
        }])->where('id', $category_id_right_second)->first();

       $recent_posts = Post::where('post_type', $post_type)->where('post_status', 'publish')
       ->latest()->take($number_of_news_to_show_in_banner)->get();
       
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
            'user' => $user,
            'language' => $language,
        ]);
    }
}
