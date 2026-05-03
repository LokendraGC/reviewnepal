<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Post\PostStoreRequest;
use App\Repositories\CategoryPostRepository;
use App\Http\Requests\Post\PostUpdateRequest;

class PostNeController extends Controller
{
    private $postType;
    private $postRepository;
    private $categoryPostRepository;
    protected $service;

    public function __construct(PostService $service, CategoryPostRepository $categoryPostRepository, PostRepository $postRepository)
    {
        // $this->middleware('permission:create_post', ['only' => ['create', 'store']]);
        // $this->middleware('permission:read_post', ['only' => ['index']]);
        // $this->middleware('permission:update_post', ['only' => ['update', 'edit']]);
        // $this->middleware('permission:delete_post', ['only' => 'destroy']);

        $this->postType = 'post_ne';
        $this->postRepository = $postRepository;
        $this->categoryPostRepository = $categoryPostRepository;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $type = $request->get('type', 'all');

        return view('backend.posts_ne.index-post_ne', [
            'status' => $status,
            'postType' => $type,
        ]);
    }

    public function create()
    {
        $type = $this->postRepository->encodeType($this->postType);
        $categories = $this->postRepository->getPostByCategory('category')->orderBy('name', 'ASC')->get();
        $authors = $this->postRepository->getPostByCategory('author')->orderBy('name', 'ASC')->get();
        // $tags = $this->postRepository->getPostByCategory('tag')->orderBy('name', 'ASC')->get();

        return view('backend.posts_ne.create-post_ne', [
            'categories' => $categories,
            'authors' => $authors,
            // 'tags' => $tags,
            'type' => $type,
        ]);
    }

    public function store(PostStoreRequest $request)
    {

        $request->validate([
            'post_name' => 'required',
            // 'featured_image' => 'required',
            // 'categories' => 'required',
        ]);

        // $type = isset($request->type) ? $this->postRepository->decodeType($request->type) : 'NOT FOUND';
        $type = $this->postType;


        // check post type exists or not
        $this->postRepository->checkPostTypeExists($type);

        try {

            // check whether click on draft or publish
            $request->merge(['post_status' => $request->input('action')]);

            // create new post
            $post = $this->postRepository->createPost($request, $this->postType);

            // store categories
            $categories = isset($request->categories) ? $request->categories : [];
            $authors = isset($request->authors) ? $request->authors : [];
            $tags = isset($request->tags) ? $request->tags : [];
            // $tags = isset( $request->tags ) ? $this->categoryPostRepository->createCustomCategory('tag', $request->tags) : [];

            $cats = array_unique(array_merge($categories, $authors, $tags));
            $this->categoryPostRepository->assignCategory($post, $cats);

            $this->postRepository->storeMetaData($post, $request);

            // update slug
            // $post->update([
            //     'slug' => date('Y/m/').$post->id,
            // ]);

            session()->flash('success', 'Post Created.');

            return to_route('backend.post_ne.edit', $post->id);
        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $post = Post::with(['categories', 'lastUpdatedBy'])->where('post_type', $this->postType)->findOrFail($id);
        
        $categories = $this->postRepository->getPostByCategory('category')->orderBy('name', 'ASC')->get();
        $authors = $this->postRepository->getPostByCategory('author')->orderBy('name', 'ASC')->get();
        // $tags = $this->postRepository->getPostByCategory('tag')->orderBy('name', 'ASC')->get();

        $metaDatas = $this->postRepository->getMetaDatas($post);

        return view('backend.posts_ne.edit-post_ne', [
            'post' => $post,
            'categories' => $categories,
            'authors' => $authors,
            // 'tags' => $tags,
            'metaDatas' => $metaDatas,
        ]);
    }

    public function update(PostUpdateRequest $request, Post $id)
    {
        $request->validate([
            'post_name' => 'required',
            // 'featured_image' => 'required',
            // 'categories' => 'required',
        ]);

        try {

            // check whether click on draft or publish
            $request->merge(['post_status' => $request->input('action')]);

            $data = $this->postRepository->updatePost($request, $id, $this->postType);

            if ($data['status'] && $data['post']) {

                $post = $data['post'];

                // get all categories
                $categories = isset($request->categories) ? $request->categories : [];
                $authors = isset($request->authors) ? $request->authors : [];
                // $tags = isset( $request->tags ) ? $request->tags : [];
                $tags = isset($request->tags) ? $this->categoryPostRepository->createCustomCategory('tag', $request->tags) : [];

                $cats = array_unique(array_merge($categories, $authors, $tags));
                $this->categoryPostRepository->assignCategory($post, $cats);

                $this->postRepository->storeMetaData($post, $request);

                // update slug
                // $post->update([
                //     'slug' => $post->created_at->format('Y/m/').$post->id,
                // ]);

                session()->flash('success', 'Post Updated.');
                return redirect()->back();
            } else {
                session()->flash('error', 'Error While Updating: Unable to update the post.');
            }
        } catch (\Exception $e) {

            session()->flash('error', 'Error While Updating: ' . $e->getMessage());
            Log::error($e);
        }

        return redirect()->back();
    }

    public function destroy(Post $id)
    {
        // get home page id for settings
        $pageId = Setting::where('setting_name', 'page_on_front')->value('setting_value');

        if ($id->id == $pageId) {

            session()->flash('warning', 'Nepali Home page cannot be deleted.');
            return redirect()->back();
        }

        $this->postRepository->makeTrash($id);

        session()->flash('success', 'Nepali Post Deleted.');

        return redirect()->back();
    }
}
