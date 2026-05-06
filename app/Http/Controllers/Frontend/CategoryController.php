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

        $catMeta = $this->categoryRepository->getMetaDatas($cat);

        $posts = $cat->posts()
            ->where('posts.post_status', 'publish')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(10);

        return view('frontend.category', compact('cat', 'posts', 'catMeta', 'language'));
    }
}
