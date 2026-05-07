<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Repositories\AdsRepository;
use Illuminate\Support\Facades\Log;

class AdsController extends Controller
{
    protected $setting;
    protected $adsRepository;

    public function __construct(Setting $setting, AdsRepository $adsRepository)
    {
        // $this->middleware('permission:read_ads', ['only' => ['index']] );
        // $this->middleware('permission:update_ads', ['only' => ['store']] );

        $this->setting = $setting;
        $this->adsRepository = $adsRepository;
    }

    public function index()
    {
        $settings = [];

        try {

            $settings = $this->adsRepository->index($this->setting);

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Showing: ' . $e->getMessage());
            Log::error($e);
        }

        return view('backend.ads.index-ads', [
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // validation
            $this->adsRepository->processMetaData($this->setting, $request);

            session()->flash('success', 'Updated.');

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Updating: ' . $e->getMessage());
            Log::error($e);

        }

        return redirect()->back();

    }
}
