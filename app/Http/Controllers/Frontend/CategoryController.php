<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Helpers\LanguageHelper;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index($slug)
    {
        $language = LanguageHelper::getUserLanguage();
        $post_type = $language == 'en' ? 'post' : 'post_ne';
        $page = request()->get('page', 1);

        $cacheKey = "category_{$slug}_{$language}_page_{$page}";

        $cached = Cache::remember($cacheKey, 10, function () use ($slug, $post_type) {
            $cat = Category::where(['slug' => $slug, 'type' => 'category'])->firstOrFail();
            $catMeta = $this->categoryRepository->getMetaDatas($cat);

            $childIds = $cat->children()->pluck('id')->toArray();

            if (!empty($childIds)) {
                $allCategoryIds = array_merge([$cat->id], $childIds);
                $posts = Post::whereHas('categories', function ($query) use ($allCategoryIds) {
                    $query->whereIn('categories.id', $allCategoryIds);
                })
                    ->with('postMeta')
                    ->where('posts.post_status', 'publish')
                    ->where('posts.post_type', $post_type)
                    ->orderBy('posts.created_at', 'desc')
                    ->paginate(19);
            } else {
                $posts = $cat->posts()
                    ->with('postMeta')
                    ->where('posts.post_status', 'publish')
                    ->where('posts.post_type', $post_type)
                    ->orderBy('posts.created_at', 'desc')
                    ->paginate(19);
            }

            return compact('cat', 'posts', 'catMeta');
        });

        return view('frontend.category', array_merge($cached, ['language' => $language]));
    }
}