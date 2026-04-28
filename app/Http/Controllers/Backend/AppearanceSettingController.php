<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\GeneralSettingRepository;

class AppearanceSettingController extends Controller
{
    private $generalSettingRepository;
    private $setting;

    public function __construct(GeneralSettingRepository $generalSettingRepository, Setting $setting)
    {
        $this->middleware('permission:create_appearance_settings', ['only' => ['create','store']] );
        $this->middleware('permission:read_appearance_settings', ['only' => ['index']] );
        $this->middleware('permission:update_appearance_settings', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_appearance_settings', ['only' => 'destroy']);

        $this->generalSettingRepository = $generalSettingRepository;
        $this->setting = $setting;
    }

    public function index()
    {
        $settings = $this->generalSettingRepository->index($this->setting);

        return view('backend.settings.appearance.appearance', [
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        try {

            $this->generalSettingRepository->appearanceProcessMetaData($this->setting, $request);

            session()->flash('success', 'Appearance Updated.');

            return redirect()->back();

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }
}
