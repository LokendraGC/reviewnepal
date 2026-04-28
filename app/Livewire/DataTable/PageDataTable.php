<?php

namespace App\Livewire\DataTable;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PageDataTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';
    public $status = 'all';
    public $postType = 'page';

    protected $service;

    public function boot(PostService $service): void
    {
        $this->service = $service;
    }

    public function mount($status = 'all', $postType = 'page'): void
    {
        $this->status = $status;
        $this->postType = $postType;
    }

    public function delete(Post $post): void
    {
        $post->delete();
        $this->dispatch('success', ['message' => 'Page deleted.']);
    }

    public function restore($id): void
    {
        $this->service->restorePost($id);
        $this->dispatch('success', ['message' => 'Page restored.']);
    }

    public function permanentDelete($id): void
    {
        $this->service->permanentDelete($id);
        $this->dispatch('success', ['message' => 'Page permanently deleted.']);
    }

    public function search(): void
    {
        $this->resetPage();
    }

    protected function baseQuery(bool $onlyTrashed = false)
    {
        $query = Post::with('user')->postType($this->postType);

        if ($onlyTrashed) {
            $query->onlyTrashed();
        }

        return $query;
    }

    protected function applySearch($query)
    {
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('post_title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function render()
    {
        $countsQuery = $this->baseQuery();

        $all = (clone $countsQuery)->count();
        $publishPosts = (clone $countsQuery)->postStatus('publish')->count();
        $draftPosts = (clone $countsQuery)->postStatus('draft')->count();
        $trashPosts = $this->baseQuery(true)->count();

        $postsQuery = $this->status === 'trash'
            ? $this->baseQuery(true)
            : $this->baseQuery()->when($this->status !== 'all', function ($query) {
                $query->postStatus($this->status);
            });

        $collection = $this->applySearch($postsQuery)
            ->orderBy('menu_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();

        $hierarchicalPosts = $this->toHierarchicalCollection($collection);
        $posts = $this->paginateHierarchy($hierarchicalPosts);

        return view('livewire.data-table.page-data-table', [
            'all' => $all,
            'publishPosts' => $publishPosts,
            'draftPosts' => $draftPosts,
            'trashPosts' => $trashPosts,
            'posts' => $posts,
        ]);
    }

    protected function toHierarchicalCollection(Collection $collection): Collection
    {
        $grouped = $collection->groupBy('post_parent');
        $ordered = collect();
        $this->appendChildren($grouped, 0, $ordered, 0);

        if ($ordered->count() !== $collection->count()) {
            $missing = $collection->whereNotIn('id', $ordered->pluck('id'));
            $missing->each(function ($post) use ($ordered) {
                $post->depth = 0;
                $ordered->push($post);
            });
        }

        return $ordered;
    }

    protected function appendChildren(Collection $grouped, int $parentId, Collection &$ordered, int $depth): void
    {
        $key = (string) $parentId;

        if (!$grouped->has($key)) {
            return;
        }

        $grouped->get($key)
            ->sortBy([
                ['menu_order', 'asc'],
                ['post_title', 'asc'],
            ])
            ->each(function ($post) use ($grouped, &$ordered, $depth) {
                $post->depth = $depth;
                $ordered->push($post);
                $this->appendChildren($grouped, $post->id, $ordered, $depth + 1);
            });
    }

    protected function paginateHierarchy(Collection $collection): LengthAwarePaginator
    {
        $pageName = property_exists($this, 'pageName') ? $this->pageName : 'page';
        $page = Paginator::resolveCurrentPage($pageName);
        $perPage = $this->perPage;
        $total = $collection->count();
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $results,
            $total,
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }
}

