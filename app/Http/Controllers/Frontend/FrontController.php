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
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $language = LanguageHelper::getUserLanguage();
        $post_type = $language == 'en' ? 'post' : 'post_ne';
        $user = Auth::user();

        $cached = Cache::remember("homepage_data_{$language}_v2", now()->addHour(), function () use ($post_type) {

            $pageId = SettingHelper::get_home_id() ?? 1;
            $post = Post::select('id')->find($pageId);
            $postMeta = $post->GetAllMetaData();

            // Extract category IDs
            $news_n_features_cat_id = $postMeta['category_id_left_second'] ?? null;
            $sports_cat_id = $postMeta['category_id_fourth'] ?? null;
            $views_n_opinion_cat = $postMeta['views_n_opinion_cat'] ?? null;
            $lifestyle_ent_cat = $postMeta['lifestyle_ent_cat'] ?? null;
            $art_cult_lit_cat = $postMeta['art_cult_lit_cat'] ?? null;
            $sci_tech_cat = $postMeta['sci_tech_cat'] ?? null;
            $business_brands_cat = $postMeta['business_brands_cat'] ?? null;

            // Collect all category IDs for bulk loading
            $allCategoryIds = array_filter([
                $news_n_features_cat_id,
                13, $sports_cat_id,
                $views_n_opinion_cat,
                $lifestyle_ent_cat,
                $art_cult_lit_cat,
                $sci_tech_cat,
                $business_brands_cat
            ]);

            // Preload all categories with children and meta in ONE query
            $categoriesCollection = Category::select('id', 'name', 'slug', 'parent', 'menu_order', 'type')
                ->with([
                    'children' => fn($q) => $q->select('id', 'name', 'slug', 'parent', 'menu_order', 'type')
                                             ->orderBy('menu_order', 'ASC'),
                    'categoryMeta' // Eager load category meta
                ])
                ->whereIn('id', $allCategoryIds)
                ->orWhereIn('parent', $allCategoryIds)
                ->get()
                ->keyBy('id');

            // Optimized function with eager loading
            $getCategoryWithPosts = function ($categoryIds, $take = 10) use ($post_type, $categoriesCollection) {
                if (!is_array($categoryIds)) {
                    $categoryIds = [$categoryIds];
                }
                $categoryIds = array_filter($categoryIds);

                if (empty($categoryIds)) {
                    return null;
                }

                // Get from already loaded collection
                $categories = $categoriesCollection->whereIn('id', $categoryIds)->values();

                if ($categories->isEmpty()) {
                    return null;
                }

                // Get all category IDs including children
                $allCategoryIds = [];
                foreach ($categories as $category) {
                    $allCategoryIds[] = $category->id;
                    $allCategoryIds = array_merge(
                        $allCategoryIds,
                        $category->children->pluck('id')->toArray()
                    );
                }
                $allCategoryIds = array_unique($allCategoryIds);

                // **CRITICAL: Single query with ALL eager loading**
                $posts = Post::select(
                    'posts.id',
                    'posts.post_title',
                    'posts.slug',
                    'posts.post_content',
                    'posts.created_at',
                    'posts.post_type',
                    'posts.post_status'
                )
                    ->join('category_post', 'posts.id', '=', 'category_post.post_id')
                    ->whereIn('category_post.category_id', $allCategoryIds)
                    ->where('posts.post_type', $post_type)
                    ->where('posts.post_status', 'publish')
                    ->with([
                        // Load ALL meta in one query
                        'postMeta',
                        // Load categories with their meta
                        'categories' => fn($q) => $q->with('categoryMeta')
                    ])
                    ->orderBy('posts.created_at', 'desc')
                    ->distinct()
                    ->take($take)
                    ->get();

                $mainCategory = $categories->first();
                $mainCategory->setRelation('posts', $posts);

                return (object) ['category' => $mainCategory, 'posts' => $posts];
            };

            // Recent posts with eager loading
            $recent_posts = Post::select('id', 'post_title', 'slug', 'post_excerpt', 'created_at', 'post_type', 'post_status')
                ->where('post_type', $post_type)
                ->where('post_status', 'publish')
                ->with([
                    'postMeta', // Load all meta
                    'categories' => fn($q) => $q->with('categoryMeta')
                ])
                ->latest()
                ->take($postMeta['number_of_news_to_show_in_banner'] ?? 2)
                ->get();

            return [
                'post' => $post,
                'postMeta' => $postMeta,
                'recent_posts' => $recent_posts,
                'news_n_features_data' => $getCategoryWithPosts($news_n_features_cat_id, 14),
                'sports_data' => $getCategoryWithPosts([13, $sports_cat_id], 10),
                'views_n_opinion_data' => $getCategoryWithPosts($views_n_opinion_cat, 5),
                'lifestyle_ent_data' => $getCategoryWithPosts($lifestyle_ent_cat, 6),
                'art_cult_lit_data' => $getCategoryWithPosts($art_cult_lit_cat, 4),
                'sci_tech_data' => $getCategoryWithPosts($sci_tech_cat, 4),
                'business_brands_data' => $getCategoryWithPosts($business_brands_cat, 10),
                'trendingPosts' => Cache::remember(
                    "trending_posts_{$post_type}",
                    now()->addHours(2),
                    fn() => TrendingHelper::getTrendingPosts($post_type)
                ),
            ];
        });

        // Unpack cached data
        return view('frontend.front', [
            'user' => $user,
            'language' => $language,
            'post' => $cached['post'],
            'postMeta' => $cached['postMeta'],
            'recent_posts' => $cached['recent_posts'],
            'news_n_features_cat' => $cached['news_n_features_data']?->category,
            'news_n_features_posts' => $cached['news_n_features_data']?->posts ?? collect(),
            'sports_cat' => $cached['sports_data']?->category,
            'sports_cat_posts' => $cached['sports_data']?->posts ?? collect(),
            'views_n_opinion_cat' => $cached['views_n_opinion_data']?->category,
            'views_n_opinion_posts' => $cached['views_n_opinion_data']?->posts ?? collect(),
            'lifestyle_ent_cat' => $cached['lifestyle_ent_data']?->category,
            'lifestyle_ent_posts' => $cached['lifestyle_ent_data']?->posts ?? collect(),
            'art_cult_lit_cat' => $cached['art_cult_lit_data']?->category,
            'art_cult_lit_posts' => $cached['art_cult_lit_data']?->posts ?? collect(),
            'sci_tech_cat' => $cached['sci_tech_data']?->category,
            'sci_tech_posts' => $cached['sci_tech_data']?->posts ?? collect(),
            'business_brands_cat' => $cached['business_brands_data']?->category,
            'business_brands_posts' => $cached['business_brands_data']?->posts ?? collect(),
            'trendingPosts' => $cached['trendingPosts'],
        ]);
    }
}
