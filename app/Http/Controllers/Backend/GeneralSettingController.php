<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\GeneralSettingRepository;

class GeneralSettingController extends Controller
{
    private $postRepository;
    private $generalSettingRepository;
    private $setting;

    public function __construct(PostRepository $postRepository, GeneralSettingRepository $generalSettingRepository, Setting $setting)
    {
        $this->middleware('permission:create_general_settings', ['only' => ['create','store']] );
        $this->middleware('permission:read_general_settings', ['only' => ['index']] );
        $this->middleware('permission:update_general_settings', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_general_settings', ['only' => 'destroy']);

        $this->postRepository = $postRepository;
        $this->generalSettingRepository = $generalSettingRepository;
        $this->setting = $setting;
    }

    public function index()
    {
        $settings = $this->generalSettingRepository->index($this->setting);

        $pages = $this->postRepository->getPostsByStatus('page', 'publish');
        $pageId = 0;

        if ( $pages != NULL ) {

            // get home page id for settings
            $pageId = Setting::where('setting_name', 'page_on_front')->value('setting_value');

        }

        return view('backend.settings.general', [
            'pages' => $pages,
            'pageId' => $pageId,
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        try {

            $this->generalSettingRepository->processMetaData($this->setting, $request);

            session()->flash('success', 'Settings Updated.');

            return redirect()->back();

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }
}
