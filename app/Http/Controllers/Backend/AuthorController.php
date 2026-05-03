<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;

class AuthorController extends Controller
{
    private $categoryRepository;
    private $authorRepository;
    private $categoryType;

    public function __construct(CategoryRepository $categoryRepository, AuthorRepository $authorRepository)
    {
        // $this->middleware('permission:create_author', ['only' => ['create','store']] );
        // $this->middleware('permission:read_author', ['only' => ['index']] );
        // $this->middleware('permission:update_author', ['only' => ['update','edit']] );
        // $this->middleware('permission:delete_author', ['only' => 'destroy']);

        $this->categoryType = 'author';
        $this->categoryRepository = $categoryRepository;
        $this->authorRepository = $authorRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $baseQuery = Category::whereType($this->categoryType);
        $postsQuery = clone $baseQuery;

        switch ($status) {
            case 'publish':
                $postsQuery->PostStatus('publish');
                break;
            case 'trash':
                $postsQuery->onlyTrashed();
                break;
                case 'draft':
                    $postsQuery->PostStatus('draft');
                    $posts = (clone $baseQuery)->PostStatus('draft')->get();
                    break;
        }

        $publishPosts = $status === 'publish' ? $postsQuery->count() : (clone $baseQuery)->count();
        $trashPosts = $status === 'trash' ? $postsQuery->count() : (clone $baseQuery)->onlyTrashed()->count();
        // $draftPosts = $status === 'draft' ? $postsQuery->count() : (clone $baseQuery)->PostStatus('draft')->count();
        $all = (clone $baseQuery)->count();

        $type = $this->categoryRepository->encodeType($this->categoryType);

        $categoriesQuery = Category::with('children')
            ->where('type', $this->categoryType)
            ->orderBy('name', 'ASC');

        if ($status === 'trash') {
            $categories = (clone $categoriesQuery)->onlyTrashed()->get();
        } else {
            $categories = (clone $categoriesQuery)->where('parent', 0)->get();
        }

        return view('backend.authors.index-author', [
            'status' => $status,
            'all' => $all,
            'trashPosts' => $trashPosts,
            'categories' => $categories,
            'categoryType' => $this->categoryType,
            'type' => $type,
        ]);
    }


    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);


        $type = isset($request->type) ? $this->categoryRepository->decodeType($request->type) : 'NOT FOUND';

        // check category type exists or not
        $this->categoryRepository->checkCategoryTypeExists($type);

        try {

            // create new category
            $author = $this->authorRepository->createCategory($request, $this->categoryType);

            $this->authorRepository->storeMetaData($author, $request);

            session()->flash('success', 'Author Created.');

            return redirect()->route('backend.author');
        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $category = Category::where('id', $id)->where('type', $this->categoryType)->FindOrFail($id);

        $metaDatas = $this->authorRepository->getMetaDatas($category);


        if ($category == NULL) {
            abort(404);
        }

        $authors = Category::with('children')
            ->where('type', $this->categoryType)
            ->where('id', '!=', $id)
            ->where('parent', 0)
            ->orderBy('name', 'ASC')
            ->get();

        return view('backend.authors.edit-author', [
            'id' => $id,
            'category' => $category,
            'authors' => $authors,
            'metaDatas' => $metaDatas,
        ]);
    }

    public function update(Request $request, Category $id)
    {

        // validation
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id->id,
        ]);

        try {

            $data = $this->authorRepository->updateCategory($request, $id, $this->categoryType);

            if ($data['status'] && $data['category']) {

                $category = $data['category'];

                $this->authorRepository->storeMetaData($category, $request);

                session()->flash('success', 'Author Updated.');

                return redirect()->route('backend.author.edit', $id);
            } else {

                session()->flash('error', 'Error While Updating: Unable to update the post.');
            }
        } catch (\Exception $e) {

            session()->flash('error', 'Error While Updating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $author = Category::findOrFail($id);

        // Backup the relationship
        Category::where('parent', $author->id)->update([
            'parent_id_backup' => $author->id,
            'parent' => 0,
        ]);

        $author->delete();

        session()->flash('success', 'Author Deleted.');
        return redirect()->back();
    }
}
