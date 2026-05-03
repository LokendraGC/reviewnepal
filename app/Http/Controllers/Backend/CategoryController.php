<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $categoryType;

    public function __construct(CategoryRepository $categoryRepository)
    {
        // $this->middleware('permission:create_category', ['only' => ['create','store']] );
        // $this->middleware('permission:read_category', ['only' => ['index']] );
        // $this->middleware('permission:update_category', ['only' => ['update','edit']] );
        // $this->middleware('permission:delete_category', ['only' => 'destroy']);

        $this->categoryType = 'category';
        $this->categoryRepository = $categoryRepository;
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
            $category = $this->categoryRepository->createCategory($request, $this->categoryType);

            $this->categoryRepository->storeMetaData($category, $request);

            session()->flash('success', 'Category Created.');

            return redirect()->route('backend.category');
        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $category = Category::where('id', $id)->where('type', $this->categoryType)->FindOrFail($id);

        $metaDatas = $this->categoryRepository->getMetaDatas($category);


        if ($category == NULL) {
            abort(404);
        }

        $categories = Category::with('children')
            ->where('type', $this->categoryType)
            ->where('id', '!=', $id)
            ->where('parent', 0)
            ->orderBy('name', 'ASC')
            ->get();

        return view('backend.categories.edit-category', [
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
            'name' => 'required|unique:categories,name,' . $id->id,
        ]);

        try {

            $data = $this->categoryRepository->updateCategory($request, $id, $this->categoryType);

            if ($data['status'] && $data['category']) {

                $category = $data['category'];

                $this->categoryRepository->storeMetaData($category, $request);

                session()->flash('success', 'Category Updated.');

                return redirect()->route('backend.category.edit', $id);
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
        $category = Category::findOrFail($id);

        // Backup the relationship
        Category::where('parent', $category->id)->update([
            'parent_id_backup' => $category->id,
            'parent' => 0,
        ]);

        $category->delete();

        session()->flash('success', 'Category Deleted.');
        return redirect()->back();
    }
}
