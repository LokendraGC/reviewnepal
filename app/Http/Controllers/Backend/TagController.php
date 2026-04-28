<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class TagController extends Controller
{
    private $categoryRepository;
    private $tagRepository;
    private $categoryType;

    public function __construct(CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->middleware('permission:create_tag', ['only' => ['create','store']] );
        $this->middleware('permission:read_tag', ['only' => ['index']] );
        $this->middleware('permission:update_tag', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_tag', ['only' => 'destroy']);

        $this->categoryType = 'tag';
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status') ? $request->get('status') : 'all';
        $baseQuery = Category::whereType($this->categoryType);
        $all = $categories = $baseQuery->get();
        $trashPosts = $baseQuery->onlyTrashed()->get()->count();
        switch ($status) {
            case 'publish':
                $categories = $all;
            break;
            case 'trash':
                $categories = $baseQuery->onlyTrashed()->get();
                break;
            // case 'draft':
            //     $posts = $baseQuery->PostStatus('draft')->get();
            //     break;
            default:
                break;
        }

        $type = $this->categoryRepository->encodeType($this->categoryType);

        // $categories = Category::with('children')
        // ->where('type', $this->categoryType)
        // ->where('parent', 0)
        // ->orderBy('name', 'ASC')
        // ->get();

        return view('backend.tags.index-tag', [
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


        $type = isset( $request->type ) ? $this->categoryRepository->decodeType($request->type) : 'NOT FOUND';

        // check category type exists or not
        $this->categoryRepository->checkCategoryTypeExists($type);

        try {

            // create new category
            $category = $this->categoryRepository->createCategory($request, $this->categoryType);

            $metaDatas = $this->tagRepository->processMetaData($category, $request);

            foreach ($metaDatas as $key => $value) {
                $this->categoryRepository->updateOrCreateMeta($category, $key, $value);
            }

            session()->flash('success', 'Tag Created.');

            return to_route('backend.tag');

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $category = Category::where('id', $id)->where('type', $this->categoryType)->FindOrFail($id);

        $metaDatas = $this->tagRepository->processMetaData($category, $request);

        foreach ($metaDatas as $key => $value) {
            $this->categoryRepository->updateOrCreateMeta($category, $key, $value);
        }

        if ( $category == NULL  ) {
            abort(404);
        }

        $categories = Category::with('children')
        ->where('type', $this->categoryType)
        ->where('id', '!=', $id)
        ->where('parent', 0)
        ->orderBy('name', 'ASC')
        ->get();

        return view('backend.tags.edit-tag', [
            'id' => $id,
            'category' => $category,
            'categories' => $categories,
            'metaDatas' => $metaDatas,
        ]);
    }

    public function update(Request $request, Category $id)
    {
        // validation
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id->id
        ]);

        try {

            $data = $this->categoryRepository->updateCategory($request, $id, $this->categoryType);

            if ( $data['status'] && $data['category'] ) {

                $category = $data['category'];

                $metaDatas = $this->tagRepository->processMetaData($category, $request);

                foreach ($metaDatas as $key => $value) {
                    $this->categoryRepository->updateOrCreateMeta($category, $key, $value);
                }

                session()->flash('success', 'Tag Updated.');

                return to_route('backend.tag.edit', $id);

            }
            else {

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
        $category = Category::where('type', $this->categoryType)->findOrFail($id);
        $category->delete();

        session()->flash('success', 'Tag Deleted.');
        return redirect()->back();
    }
}
