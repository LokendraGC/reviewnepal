<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Helpers\LanguageHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Helpers\TrendingHelper;
use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\Cache;


class FrontController extends Controller
{
    public function index()
    {
        $language = LanguageHelper::getUserLanguage();
        $post_type = $language == 'en' ? 'post' : 'post_ne';
        $user = Auth::user();

        $cached = Cache::remember("homepage_data_{$language}", 10, function () use ($post_type) {

            $pageId = SettingHelper::get_home_id() ?? 1;
            $post = Post::findOrFail($pageId);
            $postMeta = $post->GetAllMetaData();

            $number_of_news_to_show_in_banner = $postMeta['number_of_news_to_show_in_banner'] ?? 2;
            $news_n_features_cat_id = $postMeta['category_id_left_second'] ?? null;
            $sports_cat_id = $postMeta['category_id_fourth'] ?? null;
            $views_n_opinion_cat = $postMeta['views_n_opinion_cat'] ?? null;
            $lifestyle_ent_cat = $postMeta['lifestyle_ent_cat'] ?? null;
            $art_cult_lit_cat = $postMeta['art_cult_lit_cat'] ?? null;
            $sci_tech_cat = $postMeta['sci_tech_cat'] ?? null;
            $business_brands_cat = $postMeta['business_brands_cat'] ?? null;

            // RECENT POSTS
            $recent_posts = Post::where('post_type', $post_type)->where('post_status', 'publish')
                ->with(['postMeta', 'categories.categoryMeta'])
                ->latest()->take($number_of_news_to_show_in_banner)->get();

            $getCategoryWithPosts = function ($categoryIds, $take = 10) use ($post_type) {
                if (!is_array($categoryIds)) {
                    $categoryIds = [$categoryIds];
                }
                $categoryIds = array_filter($categoryIds);

                if (empty($categoryIds)) {
                    return null;
                }

                $categories = Category::with(['children' => function ($query) {
                    $query->orderBy('menu_order', 'ASC');
                }])->whereIn('id', $categoryIds)->get();

                if ($categories->isEmpty()) {
                    return null;
                }

                $allCategoryIds = [];
                foreach ($categories as $category) {
                    $allCategoryIds[] = $category->id;
                    $allCategoryIds = array_merge($allCategoryIds, $category->children->pluck('id')->toArray());
                }
                $allCategoryIds = array_unique($allCategoryIds);

                $posts = Post::whereHas('categories', function ($query) use ($allCategoryIds) {
                    $query->whereIn('categories.id', $allCategoryIds);
                })
                    ->with(['postMeta', 'categories.categoryMeta'])
                    ->where('post_type', $post_type)
                    ->where('post_status', 'publish')
                    ->orderBy('created_at', 'desc')
                    ->take($take)
                    ->get();

                $mainCategory = $categories->first();
                $mainCategory->setRelation('posts', $posts);

                return (object) ['category' => $mainCategory, 'posts' => $posts];
            };

            $news_n_features_data  = $getCategoryWithPosts($news_n_features_cat_id, 14);
            $sports_data           = $getCategoryWithPosts([13, $sports_cat_id], 10);
            $views_n_opinion_data  = $getCategoryWithPosts($views_n_opinion_cat, 5);
            $lifestyle_ent_data    = $getCategoryWithPosts($lifestyle_ent_cat, 6);
            $art_cult_lit_data     = $getCategoryWithPosts($art_cult_lit_cat, 4);
            $sci_tech_data         = $getCategoryWithPosts($sci_tech_cat, 4);
            $business_brands_data  = $getCategoryWithPosts($business_brands_cat, 10);

            return [
                'post'                  => $post,
                'postMeta'              => $postMeta,
                'recent_posts'          => $recent_posts,
                'news_n_features_cat'   => $news_n_features_data?->category,
                'news_n_features_posts' => $news_n_features_data?->posts ?? collect(),
                'sports_cat'            => $sports_data?->category,
                'sports_cat_posts'      => $sports_data?->posts ?? collect(),
                'views_n_opinion_cat'   => $views_n_opinion_data?->category,
                'views_n_opinion_posts' => $views_n_opinion_data?->posts ?? collect(),
                'lifestyle_ent_cat'     => $lifestyle_ent_data?->category,
                'lifestyle_ent_posts'   => $lifestyle_ent_data?->posts ?? collect(),
                'art_cult_lit_cat'      => $art_cult_lit_data?->category,
                'art_cult_lit_posts'    => $art_cult_lit_data?->posts ?? collect(),
                'sci_tech_cat'          => $sci_tech_data?->category,
                'sci_tech_posts'        => $sci_tech_data?->posts ?? collect(),
                'business_brands_cat'   => $business_brands_data?->category,
                'business_brands_posts' => $business_brands_data?->posts ?? collect(),
                'trendingPosts'         => TrendingHelper::getTrendingPosts($post_type),
            ];
        });

        return view('frontend.front', array_merge($cached, [
            'user'     => $user,
            'language' => $language,
        ]));
    }
}