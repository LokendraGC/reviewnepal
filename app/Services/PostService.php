<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function countAll($postType)
    {
        return $this->repository->countAll($postType);
    }

    public function countByStatus($postType, $status)
    {
        return $this->repository->countByStatus($postType, $status);
    }

    public function countTrashedPosts($postType)
    {
        return $this->repository->countTrashedPosts($postType);
    }

    public function getPostsByStatus($postType, $status = 'all', $search = '')
    {
        $query = $this->repository->query()->with('user')->postType($postType);

        if ($status !== 'all') {
            if ($status === 'trash') {
                $query->onlyTrashed();
            } else {
                $query->postStatus($status);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('post_title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        return $query->latest();
    }

    public function restorePost($id)
    {
        return $this->repository->restorePost($id);
    }

    public function permanentDelete($id)
    {
        return $this->repository->permanentDelete($id);
    }
}