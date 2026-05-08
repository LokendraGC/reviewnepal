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
            ->whereSlug($slug)
            ->where('post_status', 'publish')
            ->first();
    }

    public function getMetaData($post)
    {
        return $post->GetAllMetaData();
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

        $metaDatas = $this->getMetaData($post);

        $homePage = Post::where('slug', 'home')->where('post_status', 'publish')->first();
        $homeMeta = $homePage ? $this->getMetaData($homePage) : [];


        if ($post->post_type === 'page') {


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
        }



        if ($post->post_type === 'post') {

            $author = $post->categories()->where('categories.type', 'author')->first();
            $user = Auth::user();

            $category = $post->categories()->first();

            $relatedPosts = $this->postRepository->getRelatedPosts($post->id, $post->post_type);

            $trendingPosts = TrendingHelper::getTrendingPosts($post->post_type);

            $postMeta = $this->getMetaData($post);


            return view('frontend.single-post', [
                'post' => $post,
                'postMeta' => $postMeta,
                'author' => $author,
                'user' => $user,
                'category' => $category,
                'relatedPosts' => $relatedPosts,
                'trendingPosts' => $trendingPosts,
            ]);
        }


        if ($post->post_type === 'post_ne') {
            $author = $post->categories()->where('categories.type', 'author')->first();
            $user = Auth::user();
            $category = $post->categories()->first();
            $categoryMeta = $this->categoryRepository->getMetaDatas($category);

            $relatedPosts = $this->postRepository->getRelatedPosts($post->id, $post->post_type);
            $trendingPosts = TrendingHelper::getTrendingPosts($post->post_type);

            $postMeta = $this->getMetaData($post);

            return view('frontend.single-post_ne', [
                'post' => $post,
                'postMeta' => $postMeta,
                'author' => $author,
                'user' => $user,
                'category' => $category,
                'categoryMeta' => $categoryMeta,
                'relatedPosts' => $relatedPosts,
                'trendingPosts' => $trendingPosts,
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
