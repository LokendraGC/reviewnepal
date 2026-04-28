<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\CategoryHelper;
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

        // $homePage = Post::where('slug', 'home')->where('post_status', 'publish')->first();
        // $homeMeta = $homePage ? $this->getMetaData($homePage) : [];


        // if ($post->post_type === 'page') {
        //     $bod_cat = Category::where('type', 'team_category')->where('id', 1)->first();
        //     $management_cat = Category::where('type', 'team_category')->where('id', 2)->first();

        //     $all_teams = Post::where('post_type', 'team')->where('post_status', 'publish')->get();

        //     $bods = $all_teams->filter(function ($team) use ($bod_cat) {
        //         if (!$bod_cat)
        //             return false;
        //         $meta = $team->GetAllMetaData();
        //         $cats = isset($meta['team_categories']) ? unserialize($meta['team_categories']) : [];
        //         return is_array($cats) && in_array($bod_cat->id, $cats);
        //     });

        //     $management_teams = $all_teams->filter(function ($team) use ($management_cat) {
        //         if (!$management_cat)
        //             return false;
        //         $meta = $team->GetAllMetaData();
        //         $cats = isset($meta['team_categories']) ? unserialize($meta['team_categories']) : [];
        //         return is_array($cats) && in_array($management_cat->id, $cats);
        //     });

        //     $companies = Post::where('post_type', 'company')->where('post_status', 'publish')->get();
        //     $sectors = Category::where('type', 'sector')->get();

        //     // Media Page Data
        //     $mediasQuery = Post::where('post_type', 'media')->where('post_status', 'publish')->latest();

        //     // Extract Years from all published media before filtering
        //     $all_medias = (clone $mediasQuery)->get();
        //     $media_years = $all_medias->map(function ($media) {
        //         $meta = $media->GetAllMetaData();
        //         return $meta['year'] ?? \Carbon\Carbon::parse($media->created_at)->format('Y');
        //     })->filter()->unique()->sortDesc();

        //     // Apply Filters if template is media or media-coverage (filtering done client-side for no page refresh)
        //     if (isset($metaDatas['page_template']) && in_array($metaDatas['page_template'], ['media', 'media-coverage'])) {
        //         $medias = $all_medias;

        //         $stories = Post::where('post_type', 'story')->where('post_status', 'publish')->latest()->get();
        //     } else {
        //         $medias = collect();
        //         $stories = collect();
        //     }

        //     $viewName = $this->getViewName($post, $metaDatas);

        //     $posts = Post::where('post_type', 'post')->where('post_status', 'publish')
        //         ->whereHas('categories', fn($q) => $q->where('categories.id', 9))
        //         ->latest()->get();
        //     $events = Post::where('post_type', 'post')->where('post_status', 'publish')
        //         ->whereHas('categories', fn($q) => $q->where('categories.id', 10))
        //         ->latest()->get();
        //     $press_releases = Post::where('post_type', 'post')->where('post_status', 'publish')
        //         ->whereHas('categories', fn($q) => $q->where('categories.id', 11))
        //         ->latest()->get();

        //     if ($viewName) {
        //         return view($viewName, [
        //             'post' => $post,
        //             'metaData' => $metaDatas,
        //             'homeMeta' => $homeMeta,
        //             'bod_cat' => $bod_cat,
        //             'board_of_directors' => $bods,
        //             'management_cat' => $management_cat,
        //             'management_teams' => $management_teams,
        //             'companies' => $companies,
        //             'sectors' => $sectors,
        //             'medias' => $medias,
        //             'stories' => $stories,
        //             'media_years' => $media_years,
        //             'total_medias_count' => $all_medias->count(),
        //             'total_stories_count' => isset($stories) ? $stories->count() : 0,
        //             'posts' => $posts,
        //             'events' => $events,
        //             'press_releases' => $press_releases,
        //         ]);
        //     }
        // }

        if ($post->post_type === 'post') {
            $related_posts = Post::where('post_type', 'post')->where('post_status', 'publish')->where('id', '!=', $post->id)->latest()->take(3)->get();

            return view('frontend.single-post', [
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
