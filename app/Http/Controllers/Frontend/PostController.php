<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepository;
use App\Helpers\TrendingHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\SettingHelper;
use App\Helpers\MediaHelper;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    private $categoryRepository;
    private $postRepository;

    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }
    

    public function index($slug, $month = null, $id = null)
    {
        if ($id !== null) {
            $slug = Post::query()
                ->where('id', $id)
                ->where('post_status', 'publish')
                ->value('slug') ?? $id;
        }

        return $this->handlePost($slug);
    }

public function getPayload($slug)
{
    return Post::query()
        ->with([
            'postMeta',
            'categories',
            'categories.categoryMeta'
        ])
        ->whereSlug($slug)
        ->where('post_status', 'publish')
        ->first();
}

    public function getMetaData($post)
    {
        return $post->GetAllMetaData();
    }

    private function resolveAd(string $settingKey): array
    {
        $mediaId = SettingHelper::get_field($settingKey);
        if (!$mediaId) {
            return ['url' => null, 'link' => null];
        }
        $media = MediaHelper::getImageById($mediaId);
        return [
            'url'  => ($media && !empty($media->file_name)) ? asset('storage/' . $media->file_name) : null,
            'link' => $media->description ?? null,
        ];
    }

    private function getSinglePostSettings(): array
    {
        $logoId    = SettingHelper::get_field('header_logo');
        $logoMedia = $logoId ? MediaHelper::getImageById($logoId) : null;

        return [
            'site_title'     => SettingHelper::get_field('site_title'),
            'logo_url'       => ($logoMedia && !empty($logoMedia->file_name))
                                    ? asset('storage/' . $logoMedia->file_name)
                                    : asset('assets/images/reviewnepal-logo.svg'),
            'above_title'    => $this->resolveAd('single_above_title'),
            'below_title'    => $this->resolveAd('single_below_title'),
            'below_featured' => $this->resolveAd('below_featured_image_ad'),
            'sidebar_first'  => $this->resolveAd('single_news_below_trending_news_first_ad'),
            'sidebar_second' => $this->resolveAd('single_news_below_trending_news_second_ad'),
            'below_content'  => $this->resolveAd('single_below_content'),
        ];
    }

    public function getViewName($post, $metaDatas)
    {
        if ($post->post_type === 'page') {
            return "frontend.pages.{$metaDatas['page_template']}";
        }

        return null;
    }

private function handlePost($slug)
{
    $post = $this->getPayload($slug);

    if (!$post) {
        return response()->view('frontend.not-found', [], 404);
    }

    // 1. Pages (About Us, Contact, etc.)
    if ($post->post_type === 'page') {
        $metaDatas = $this->getMetaData($post);
        $homePage = Post::where('slug', 'home')->where('post_status', 'publish')->first();
        $homeMeta = $homePage ? $this->getMetaData($homePage) : [];
        $viewName = $this->getViewName($post, $metaDatas);

        $posts = Post::where('post_type', 'post')->where('post_status', 'publish')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 9))
            ->latest()->get();

        if ($viewName) {
            return view($viewName, [
                'post' => $post,
                'metaData' => $metaDatas,
                'homeMeta' => $homeMeta,
                'posts' => $posts,
            ]);
        }
        abort(403, 'Not Found');
    }

    // 2. Posts - NO CACHING (direct queries)
    $user = Auth::user();

    if ($post->post_type === 'post') {
        $author = $post->categories->firstWhere('type', 'author');
        $category = $post->categories->firstWhere('type', 'category');
        $relatedPosts = $this->postRepository->getRelatedPosts($post->id, $post->post_type);
        $trendingPosts = Cache::remember(
            "trending_{$post->post_type}",
            300,
            function () use ($post) {
                return TrendingHelper::getTrendingPosts($post->post_type)
                    ->load([
                        'postMeta',
                        'categories'
                    ]);
            }
        );
        $postMeta = $this->getMetaData($post);

        return view('frontend.single-post', [
            'post'          => $post,
            'postMeta'      => $postMeta,
            'author'        => $author,
            'user'          => $user,
            'category'      => $category,
            'relatedPosts'  => $relatedPosts,
            'trendingPosts' => $trendingPosts,
            'settings'      => $this->getSinglePostSettings(),
        ]);
    }

    if ($post->post_type === 'post_ne') {
        $author = $post->categories->firstWhere('type', 'author');
        $category = $post->categories->firstWhere('type', 'category');
        $categoryMeta = $category ? $this->categoryRepository->getMetaDatas($category) : [];
        $relatedPosts = $this->postRepository->getRelatedPosts($post->id, $post->post_type);
        $trendingPosts = Cache::remember(
            "trending_{$post->post_type}",
            300,
            function () use ($post) {
                return TrendingHelper::getTrendingPosts($post->post_type)
                    ->load(['postMeta', 'categories']);
            }
        );
        $postMeta = $this->getMetaData($post);

        return view('frontend.single-post_ne', [
            'post'          => $post,
            'postMeta'      => $postMeta,
            'author'        => $author,
            'user'          => $user,
            'category'      => $category,
            'categoryMeta'  => $categoryMeta,
            'relatedPosts'  => $relatedPosts,
            'trendingPosts' => $trendingPosts,
            'settings'      => $this->getSinglePostSettings(),
        ]);
    }

    abort(403, 'Not Found');
}

    public function search(Request $request)
    {
        $query = trim((string) $request->input('search', ''));

        $categoryId = $request->input('category');  // optional: category id

        $language = LanguageHelper::getUserLanguage();

        // Get sector categories for fallback list; filter by search query when provided.
        $categoriesQuery = Category::query()->where('type', 'category');
        if ($query !== '') {
            $categoriesQuery->where('name', 'like', '%' . $query . '%');
        }
        $categories = $categoriesQuery->get();

        // Build query
        $postsQuery = Post::query()
            ->where('post_status', 'publish');

        // Include all 3 types
        $postsQuery->whereIn('post_type', ['post', 'post_ne']);

        // Search by post title or related category name.
        $postsQuery->when($query !== '', function ($q) use ($query) {
            $q->where(function ($subQuery) use ($query) {
                $subQuery->where('post_title', 'like', '%' . $query . '%')
                    ->orWhereHas('categories', function ($categoryQuery) use ($query) {
                        $categoryQuery->where('categories.name', 'like', '%' . $query . '%');
                    });
            });
        });


        // Filter by sector category if provided
        if ($categoryId) {
            $postsQuery->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Get results
        $posts = $postsQuery->latest()->paginate(12)->appends($request->all());

        // Get the selected category name if categoryId is provided
        $selectedCategory = null;
        if ($categoryId) {
            $selectedCategory = Category::find($categoryId);
        }

        // Prepare layout variables
        $payload = $posts->first() ?? new Post();
        $payloadMeta = [
            'seo_title' => $query ? 'Search results for: ' . $query : 'Search Results',
            'seo_description' => 'Search results for ' . $query . ' on Review Nepal.',
        ];

        return view('frontend.pages.search_result', [
            'posts' => $posts,
            'categories' => $categories,
            'query' => $query,
            'categoryId' => $categoryId,
            'selectedCategory' => $selectedCategory,
            'payload' => $payload,
            'payloadMeta' => $payloadMeta,
            'title' => $payloadMeta['seo_title'],
            'language' => $language
        ]);
    }
}
