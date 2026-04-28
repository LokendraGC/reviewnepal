<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Post\PostStoreRequest;
use App\Repositories\CategoryPostRepository;
use App\Http\Requests\Post\PostUpdateRequest;

class TeamController extends Controller
{
    private $postType;
    private $postRepository;
    private $teamRepository;

    public function __construct(PostRepository $postRepository, TeamRepository $teamRepository)
    {
        // $this->middleware('permission:create_team', ['only' => ['create','store']] );
        // $this->middleware('permission:read_team', ['only' => ['index']] );
        // $this->middleware('permission:update_team', ['only' => ['update','edit']] );
        // $this->middleware('permission:delete_team', ['only' => 'destroy']);

        $this->postType = 'team';
        $this->teamRepository = $teamRepository;
        $this->postRepository = $postRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status') ? $request->get('status') : 'all';
        $baseQuery = Post::PostType($this->postType);
        $all = $posts = $baseQuery->get();

        switch ($status) {
            case 'publish':
                $posts = $baseQuery->PostStatus('publish')->get();
            break;
            case 'trash':
                $posts = $baseQuery->onlyTrashed()->get();
                break;
            case 'draft':
                $posts = $baseQuery->PostStatus('draft')->get();
                break;
            default:
                break;
        }
        $publishPosts = Post::PostType($this->postType)->PostStatus('publish')->get()->count();
        $trashPosts = Post::PostType($this->postType)->onlyTrashed()->get()->count();
        $draftPosts = Post::PostType($this->postType)->PostStatus('draft')->get()->count();

        return view('backend.team.index-team', [
            'status' => $status,
            'all' => $all,
            'posts' => $posts,
            'draftPosts' => $draftPosts,
            'publishPosts' => $publishPosts,
            'trashPosts' => $trashPosts,
            'postType' => $this->postType,
        ]);
    }

    public function create()
    {
        $type = $this->postRepository->encodeType($this->postType);

        return view('backend.team.create-team', [
            'type' => $type,
        ]);
    }

    public function store(PostStoreRequest $request)
    {
        $type = isset( $request->type ) ? $this->postRepository->decodeType($request->type) : 'NOT FOUND';

        // check post type exists or not
        $this->postRepository->checkPostTypeExists($type);

        try {

            // check whether click on draft or publish
            $request->merge(['post_status' => $request->input('action')]);

            $post = $this->postRepository->createPost($request, $this->postType);

            $metaDatas =  $this->teamRepository->processMetaData($post, $request);

            foreach ($metaDatas as $key => $value) {
                $this->postRepository->updateOrCreateMeta($post, $key, $value);
            }

            session()->flash('success', 'Team Created.');

            return redirect()->route('backend.team.edit', $post->id);

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $post = Post::where('post_type', $this->postType)->findOrFail($id);

        $metaDatas = $this->postRepository->getMetaDatas($post);

        return view('backend.team.edit-team', [
            'post' => $post,
            'metaDatas' => $metaDatas,
        ]);
    }

    public function update(PostUpdateRequest $request, Post $id)
    {
        try {

            // check whether click on draft or publish
            $request->merge(['post_status' => $request->input('action')]);

            $data = $this->postRepository->updatePost($request, $id, $this->postType);

            if ( $data['status'] && $data['post'] ) {

                $post = $data['post'];

                $metaDatas =  $this->teamRepository->processMetaData($post, $request);

                foreach ($metaDatas as $key => $value) {
                    $this->postRepository->updateOrCreateMeta($post, $key, $value);
                }

                session()->flash('success', 'Team Updated.');

                // return redirect()->route('backend.page.edit', $id);
                return redirect()->back();

            }
            else {
                session()->flash('error', 'Error While Updating: Unable to update the page.');
            }

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Updating: ' . $e->getMessage());
            Log::error($e);
        }

        return redirect()->back();

    }

}


