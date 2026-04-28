<?php

namespace App\Livewire\DataTable;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryDataTable extends Component
{
    use WithPagination;
    
    public $categoryType = 'category';
    public $siteURL;
    public $status;
    public $perPage = 10;
    public $search = '';

    public function render()
    {
        $categoriesQuery = Category::with('children')
            ->where('type', $this->categoryType)
            ->when($this->search, function ($query) {
                // When searching, ignore parent=0 and search by name across all categories
                $query->where('name', 'like', '%' . $this->search . '%');
            }, function ($query) {
                // When no search, filter parent=0 (top-level categories)
                $query->where('parent', 0);
            })
            ->when($this->status === 'trash', function ($query) {
                $query->onlyTrashed();
            })
            ->withCount('posts')
            ->orderBy('name', 'ASC');

        return view('livewire.data-table.category-data-table', [
            'categories' => $categoriesQuery->paginate($this->perPage),
        ]);
    }


    public function displaySubCategoriesTable($categories, $level = 0)
    {
        $html = '';
        foreach ($categories as $category) {
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<span class="fw-600">' . str_repeat('— ', $level) . $category->name . '</span>';
            $html .= '<div class="row-action">';
            $html .= '<span class="edit"><a href="' . route('backend.category.edit', $category->id) . '" class="text-primary">Edit</a></span>';
            $html .= '<span class="delete"> | <a href="' . route('backend.category.delete', $category->id) . '" onclick="return confirm(\'Are you sure you want to delete?\');" class="text-danger">Delete</a></span>';
            $html .= '<span class="view"> | <a href="' . $this->siteURL . '/category/' . $category->slug . '" class="text-primary" target="_blank">View</a></span>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '<td>' . $category->slug . '</td>';
            $html .= '<td>Published <br>' . Carbon::parse($category->created_at)->format('Y-m-d h:i a') . '</td>';
            $html .= '<td>' . $category->posts_count . '</td>';
            $html .= '</tr>';

            if ($category->children->count()) {
                $html .= $this->displaySubCategoriesTable($category->children, $level + 1);
            }
        }
        return $html;
    }
}
