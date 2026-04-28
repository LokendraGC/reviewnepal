<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class AuthorController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index($id)
    {
        $cat = Category::where([ 'id' => $id, 'type' => 'author' ])->firstOrFail();

        $catMeta = $this->categoryRepository->getMetaDatas($cat);

        $posts = $cat->posts()->orderBy('created_at', 'desc')->get();

        return view('frontend.category-author', compact(['cat', 'posts', 'catMeta']) );
    }
}
