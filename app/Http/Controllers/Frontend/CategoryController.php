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

        // NO CACHING - Direct database queries
        $cat = Category::where(['slug' => $slug, 'type' => 'category'])->firstOrFail();
        $catMeta = $this->categoryRepository->getMetaDatas($cat);

        // Get category ID and child category IDs
        $childIds = $cat->children()->pluck('id')->toArray();

        if (!empty($childIds)) {
            $allCategoryIds = array_merge([$cat->id], $childIds);
            $posts = Post::whereHas('categories', function ($query) use ($allCategoryIds) {
                $query->whereIn('categories.id', $allCategoryIds);
            })
                ->where('posts.post_status', 'publish')
                ->where('posts.post_type', $post_type)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(10);
        } else {
            $posts = $cat->posts()
                ->where('posts.post_status', 'publish')
                ->where('posts.post_type', $post_type)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(10);
        }

        return view('frontend.category', compact('cat', 'posts', 'catMeta', 'language'));
    }
}