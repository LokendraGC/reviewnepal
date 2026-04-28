<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;

class SettingController extends Controller
{
    protected $setting;
    protected $settingRepository;

    public function __construct(Setting $setting, SettingRepository $settingRepository)
    {
        $this->middleware('permission:read_site_settings', ['only' => ['index']] );
        $this->middleware('permission:update_site_settings', ['only' => ['store']] );

        $this->setting = $setting;
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $settings = [];

        try {

            $settings = $this->settingRepository->index($this->setting);

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Showing: ' . $e->getMessage());
            Log::error($e);
        }

        return view('backend.settings.index-setting', [
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // validation
            $this->settingRepository->storeOrUpdate($this->setting, $request);

            session()->flash('success', 'Updated.');

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Updating: ' . $e->getMessage());
            Log::error($e);

        }

        return redirect()->back();

    }

    public function removeImage(Request $request)
    {
        $imageKey = $request->input('image_key');

        // Retrieve the setting based on the image key
        $setting = Setting::where('setting_name', $imageKey)->first();

        if ( !$setting ) {
            return response()->json(['success' => false, 'message' => 'Not found for the given image key']);
        }

        $setting->update(['setting_value' => null]);

        return response()->json(['success' => true]);
    }
}
