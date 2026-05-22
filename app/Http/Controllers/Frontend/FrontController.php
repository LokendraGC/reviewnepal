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

        // NO CACHING - Direct execution
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
            ->latest()->take($number_of_news_to_show_in_banner)->get();

        // Helper function to reduce code duplication with customizable post count
        $getCategoryWithPosts = function ($categoryIds, $take = 10) use ($post_type) {
            // Convert single ID to array for consistency
            if (!is_array($categoryIds)) {
                $categoryIds = [$categoryIds];
            }

            // Remove any null or empty values
            $categoryIds = array_filter($categoryIds);

            if (empty($categoryIds)) {
                return null;
            }

            // Get all categories
            $categories = Category::with(['children' => function ($query) {
                $query->orderBy('menu_order', 'ASC');
            }])->whereIn('id', $categoryIds)->get();

            if ($categories->isEmpty()) {
                return null;
            }

            // Collect all category IDs including children
            $allCategoryIds = [];
            foreach ($categories as $category) {
                $allCategoryIds[] = $category->id;
                $childIds = $category->children->pluck('id')->toArray();
                $allCategoryIds = array_merge($allCategoryIds, $childIds);
            }
            $allCategoryIds = array_unique($allCategoryIds);

            // Fetch posts from all categories and their children
            $posts = Post::whereHas('categories', function ($query) use ($allCategoryIds) {
                $query->whereIn('categories.id', $allCategoryIds);
            })
                ->where('post_type', $post_type)
                ->where('post_status', 'publish')
                ->orderBy('created_at', 'desc')
                ->take($take)
                ->get();

            // Use the first category as the main category object
            $mainCategory = $categories->first();
            $mainCategory->setRelation('posts', $posts);

            return (object) [
                'category' => $mainCategory,
                'posts' => $posts
            ];
        };

        // NEWS & FEATURES CATEGORY (LEFT SECOND) - 8 posts
        $news_n_features_data = $getCategoryWithPosts($news_n_features_cat_id, 14);
        $news_n_features_cat = $news_n_features_data ? $news_n_features_data->category : null;
        $news_n_features_posts = $news_n_features_data ? $news_n_features_data->posts : collect();

        // SPORTS CATEGORY - 10 posts (default)
        $sports_data = $getCategoryWithPosts([13, $sports_cat_id], 10);
        $sports_cat = $sports_data ? $sports_data->category : null;
        $sports_cat_posts = $sports_data ? $sports_data->posts : collect();

        // VIEWS AND OPINION CATEGORY 
        $views_n_opinion_data = $getCategoryWithPosts($views_n_opinion_cat, 5);
        $views_n_opinion_cat_obj = $views_n_opinion_data ? $views_n_opinion_data->category : null;
        $views_n_opinion_posts = $views_n_opinion_data ? $views_n_opinion_data->posts : collect();

        // LIFESTYLE & ENTERTAINMENT CATEGORY 
        $lifestyle_ent_data = $getCategoryWithPosts($lifestyle_ent_cat, 6);
        $lifestyle_ent_cat_obj = $lifestyle_ent_data ? $lifestyle_ent_data->category : null;
        $lifestyle_ent_posts = $lifestyle_ent_data ? $lifestyle_ent_data->posts : collect();

        // ART, CULTURE & LITERATURE CATEGORY
        $art_cult_lit_data = $getCategoryWithPosts($art_cult_lit_cat, 4);
        $art_cult_lit_cat_obj = $art_cult_lit_data ? $art_cult_lit_data->category : null;
        $art_cult_lit_posts = $art_cult_lit_data ? $art_cult_lit_data->posts : collect();

        // SCIENCE & TECHNOLOGY CATEGORY - 5 posts 
        $sci_tech_data = $getCategoryWithPosts($sci_tech_cat, 4);
        $sci_tech_cat_obj = $sci_tech_data ? $sci_tech_data->category : null;
        $sci_tech_posts = $sci_tech_data ? $sci_tech_data->posts : collect();

        // BUSINESS & BRANDS CATEGORY
        $business_brands_data = $getCategoryWithPosts($business_brands_cat, 10);
        $business_brands_cat_obj = $business_brands_data ? $business_brands_data->category : null;
        $business_brands_posts = $business_brands_data ? $business_brands_data->posts : collect();

        // TRENDING POSTS
        $trendingPosts = TrendingHelper::getTrendingPosts($post_type);

        $user = Auth::user();

        return view('frontend.front', [
            'post' => $post,
            'postMeta' => $postMeta,
            'recent_posts' => $recent_posts,
            'news_n_features_cat' => $news_n_features_cat,
            'news_n_features_posts' => $news_n_features_posts,
            'sports_cat' => $sports_cat,
            'sports_cat_posts' => $sports_cat_posts,
            'views_n_opinion_cat' => $views_n_opinion_cat_obj,
            'views_n_opinion_posts' => $views_n_opinion_posts,
            'lifestyle_ent_cat' => $lifestyle_ent_cat_obj,
            'lifestyle_ent_posts' => $lifestyle_ent_posts,
            'art_cult_lit_cat' => $art_cult_lit_cat_obj,
            'art_cult_lit_posts' => $art_cult_lit_posts,
            'sci_tech_cat' => $sci_tech_cat_obj,
            'sci_tech_posts' => $sci_tech_posts,
            'business_brands_cat' => $business_brands_cat_obj,
            'business_brands_posts' => $business_brands_posts,
            'trendingPosts' => $trendingPosts,
            'user' => $user,
            'language' => $language,
        ]);
    }
}