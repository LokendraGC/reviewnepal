<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Enums\TemplateType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;

class PageController extends Controller
{
    private $postType;
    private $postRepository;
    private $pageRepository;

    public function __construct(PageRepository $pageRepository, PostRepository $postRepository)
    {
        $this->middleware('permission:create_page', ['only' => ['create','store']] );
        $this->middleware('permission:read_page', ['only' => ['index']] );
        $this->middleware('permission:update_page', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_page', ['only' => 'destroy']);

        $this->postType = 'page';
        $this->pageRepository = $pageRepository;
        $this->postRepository = $postRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status') ? $request->get('status') : 'all';

        return view('backend.pages.index-page', [
            'status' => $status,
            'postType' => $this->postType,
        ]);
    }

    public function create()
    {
        $type = $this->postRepository->encodeType($this->postType);

        $pages = Post::with('children')
        ->where('post_type', $this->postType)
        ->where('post_parent', 0)
        ->orderBy('post_title', 'ASC')
        ->get();

        return view('backend.pages.create-page', [
            'type' => $type,
            'pages' => $pages,
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

            $metaDatas = [];
            if ( isset( $request->page_template ) ) {

                if (in_array($request->page_template, TemplateType::toArray()) && $request->page_template != 'default') {
                    $metaDatas['page_template'] = $request->page_template;
                    $metaDatas = array_merge($metaDatas, $this->pageRepository->findTemplateMethod($post, $request));
                }
                else {
                    $metaDatas['page_template'] = 'default';
                }
            }
            else {
                $metaDatas['page_template'] = 'default';
            }

            $metaDatas = array_merge($metaDatas, $this->pageRepository->processMetaData($post, $request) );

            foreach ($metaDatas as $key => $value) {
                $this->postRepository->updateOrCreateMeta($post, $key, $value);
            }

            session()->flash('success', 'Page Created.');

            return redirect()->route('backend.page.edit', $post->id);

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $post = Post::with(['categories', 'postMeta'])->where('post_type', $this->postType)->findOrFail($id);

        $metaDatas = $this->postRepository->getMetaDatas($post);

        $pageTemplate = isset( $metaDatas['page_template'] ) ? $metaDatas['page_template'] : NULL;

        if ( $pageTemplate ) {

            if (in_array($pageTemplate, TemplateType::toArray()) && $pageTemplate != 'default') {
                try {


                    $viewName = "backend.templates-pages.$pageTemplate";

                    if (View::exists($viewName)) {

                        $view = View::make($viewName)->with('metaDatas', $metaDatas)->render();
                    } else {
                        $view = NULL;
                    }

                } catch (\Exception $e) {
                    session()->flash('error', 'Error While Showing: ' . $e->getMessage());
                    $view = NULL;
                }

            } else {
                $view = NULL;
            }
        }
        else {
            $view = NULL;
        }

        $pages = Post::with('children')
        ->where('post_type', $this->postType)
        ->where('post_parent', 0)
        ->orderBy('post_title', 'ASC')
        ->get();

        return view('backend.pages.edit-page', [
            'post' => $post,
            'metaDatas' => $metaDatas,
            'view' => $view,
            'pages' => $pages,
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

                $metaDatas = [];

                if ( isset( $request->page_template ) ) {
                    if (in_array($request->page_template, TemplateType::toArray()) && $request->page_template != 'default') {
                        $metaDatas['page_template'] = $request->page_template;
                        $metaDatas = array_merge($metaDatas, $this->pageRepository->findTemplateMethod($post, $request));
                    }
                    else {
                        $metaDatas['page_template'] = 'default';
                    }
                }
                else {
                    $metaDatas['page_template'] = 'default';
                }

                $metaDatas = array_merge($metaDatas, $this->pageRepository->processMetaData($post, $request) );

                foreach ($metaDatas as $key => $value) {
                    $this->postRepository->updateOrCreateMeta($post, $key, $value);
                }

                session()->flash('success', 'Page Updated.');

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

    // get template view
    public function getPageTemplate(Request $request)
    {
        if (!in_array($request->template, TemplateType::toArray())) {
            return [ 'status' => false ];
        }

        $html = $this->pageRepository->getTemplateView($request->template);

        return [
            'status' => true,
            'data' => $html,
         ];
    }

    // get template view when edit page
    public function getEditPageTemplate(Request $request)
    {
        if (!in_array($request->template, TemplateType::toArray())) {
            return [ 'status' => false ];
        }
        $post = Post::where('id', $request->pageID)->first();

        $html = $this->pageRepository->getEditTemplateView($request, $post);

        return [
            'status' => true,
            'data' => $html,
         ];
    }
}
