<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\CategoryRepository;

class TrashController extends Controller
{
    private $postRepository;
    private $categoryRepository;

    public function __construct(PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index($type)
    {
        // check post type exists or not
        $this->postRepository->checkPostTypeExists($type);

        $allPosts = $this->postRepository->getAllPost($type);
        $draftPosts = $this->postRepository->getPostsByStatus($type, 'draft');
        $publishPosts = $this->postRepository->getPostsByStatus($type, 'publish');
        $trashPosts = $this->postRepository->getTrashedPosts($type);
        $posts = $this->postRepository->showTrashPosts($type);

        return view('backend.posts.trash-post', [
            'allPosts' => $allPosts,
            'posts' => $posts,
            'draftPosts' => $draftPosts,
            'publishPosts' => $publishPosts,
            'trashPosts' => $trashPosts,
            'postType' => $type,
        ]);
    }

    public function restore($id)
    {
        $this->postRepository->restorePost($id);

        session()->flash('success', 'Post Restored.');

        return redirect()->back();
    }

    public function restoreCategory($id)
    {
        $this->categoryRepository->restoreCategory($id);
        session()->flash('success', 'Data Restored.');
        return redirect()->back();
    }

    public function permanentlyDelete($id)
    {
        $this->postRepository->permanentDelete($id);

        session()->flash('success', 'Post Permanently Deleted.');

        return redirect()->back();
    }

    public function permanentlyDeleteCategory($id)
    {
        $this->categoryRepository->permanentDeleteCategory($id);

        session()->flash('success', 'Permanently Deleted.');

        return redirect()->back();
    }
}
