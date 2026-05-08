<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Helpers\LanguageHelper;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index( $slug )
    {
        $cat = Category::where([ 'slug' => $slug, 'type' => 'category' ])->firstOrFail();
       
        $language = LanguageHelper::getUserLanguage();

        $post_type = $language == 'en' ? 'post' : 'post_ne';

        $catMeta = $this->categoryRepository->getMetaDatas($cat);

        $posts = $cat->posts()
            ->where('posts.post_status', 'publish')
            ->where('posts.post_type', $post_type)
            ->orderBy('posts.created_at', 'desc')
            ->paginate(10);

        return view('frontend.category', compact('cat', 'posts', 'catMeta', 'language'));
    }
}
