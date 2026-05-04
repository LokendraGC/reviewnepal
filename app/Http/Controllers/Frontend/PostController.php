<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index($slug)
    {
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
         
            // $companies = Post::where('post_type', 'company')->where('post_status', 'publish')->get();

            $viewName = $this->getViewName($post, $metaDatas);

            $posts = Post::where('post_type', 'post')->where('post_status', 'publish')
                ->whereHas('categories', fn($q) => $q->where('categories.id', 9))
                ->latest()->get();
       
            // $press_releases = Post::where('post_type', 'post')->where('post_status', 'publish')
            //     ->whereHas('categories', fn($q) => $q->where('categories.id', 11))
            //     ->latest()->get();

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
            $related_posts = Post::where('post_type', 'post')->where('post_status', 'publish')->where('id', '!=', $post->id)->latest()->take(3)->get();

            return view('frontend.single-post', [
                'post' => $post,
                'postMeta' => $metaDatas,
                'related_posts' => $related_posts,
            ]);
        }


        if ($post->post_type === 'post_ne') {
            $related_posts = Post::where('post_type', 'post_ne')->where('post_status', 'publish')->where('id', '!=', $post->id)->latest()->take(3)->get();

            return view('frontend.single-post_ne', [
                'post' => $post,
                'postMeta' => $metaDatas,
                'related_posts' => $related_posts,
            ]);
        }

        abort(403, 'Not Found');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $type = $request->input('type');  // optional: 'company', 'story', 'post'
        $sectorId = $request->input('sector');  // optional: category id

        // Get sector category info (optional)
        $sector_cat = Category::where('type', 'sector')->first();
        $sector_catMeta = $sector_cat ? $this->categoryRepository->getMetaDatas($sector_cat) : null;

        // Build query - search only in title
        $postsQuery = Post::query()
            ->where('post_status', 'publish');

        // Filter by type if provided
        if ($type) {
            $postsQuery->where('post_type', $type);
        } else {
            // If no type, include all 3 types
            $postsQuery->whereIn('post_type', ['company', 'story', 'post']);
        }

        // Search in title only (removed slug and content)
        if ($query) {
            $postsQuery->where('post_title', 'like', '%' . $query . '%');
        }

        // Filter by sector category if provided
        if ($sectorId) {
            $postsQuery->whereHas('categories', function ($q) use ($sectorId) {
                $q->where('categories.id', $sectorId);
            });
        }

        // Get results
        $posts = $postsQuery->latest()->get();

        // Get the selected sector name if sectorId is provided
        $selectedSector = null;
        if ($sectorId) {
            $selectedSector = Category::find($sectorId);
        }

        // Prepare layout variables
        $payload = $posts->first() ?? new Post();
        $payloadMeta = [
            'seo_title' => $query ? 'Search results for: ' . $query : 'Search Results',
            'seo_description' => 'Search results for ' . $query . ' on Neev.',
        ];

        return view('frontend.pages.search', [
            'posts' => $posts,
            'selectedSector' => $selectedSector,
            'sector_cat' => $sector_cat,
            'sector_catMeta' => $sector_catMeta,
            'query' => $query,
            'type' => $type,
            'sectorId' => $sectorId,
            'payload' => $payload,
            'payloadMeta' => $payloadMeta,
            'title' => $payloadMeta['seo_title']
        ]);
    }
}
