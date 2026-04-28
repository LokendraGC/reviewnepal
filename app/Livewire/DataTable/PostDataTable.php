<?php

namespace App\Livewire\DataTable;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\PostService;

class PostDataTable extends Component
{
    use WithPagination;
    
    public $perPage = 15;
    public $search = '';
    public $status = '';
    public $postType = '';

    protected $service;

    public function boot(PostService $service)
    {
        $this->service = $service;
    }

    public function mount($status = 'all', $postType)
    {
        $this->status = $status;
        $this->postType = $postType;
    }

    public function delete(Post $post)
    {
        $post->delete();
        $this->dispatch('success', [ 'message' => 'Post deleted.' ]);
    }

    public function restore($id)
    {
        $this->service->restorePost($id);
        $this->dispatch('success', [ 'message' => 'Post restored.' ]);
    }

    public function permanentDelete($id)
    {
        $this->service->permanentDelete($id);
        $this->dispatch('success', [ 'message' => 'Post permanently deleted.' ]);
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.data-table.post-data-table', [
            'all' => $this->service->countAll($this->postType),
            'draftPosts' => $this->service->countByStatus($this->postType, 'draft'),
            'publishPosts' => $this->service->countByStatus($this->postType, 'publish'),
            'trashPosts' => $this->service->countTrashedPosts($this->postType),
            'posts' => $this->service->getPostsByStatus($this->postType, $this->status, $this->search)->paginate($this->perPage),
        ]);
    }
}
