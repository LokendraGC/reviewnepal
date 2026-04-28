<?php

namespace App\Repositories;

class GeneralSettingRepository
{
    public function index($payload)
    {
        $data = $payload->pluck('setting_value', 'setting_name')->toArray();

        return $data;
    }

    public function processMetaData($payload, $request)
    {
        $metaDatas = [];
        $metaDatas['site_title'] = $request->site_title ?? null;
        $metaDatas['admin_email_address'] = $request->admin_email_address ?? null;
        $metaDatas['site_favicon'] = $request->site_favicon ?? null;

        if ( auth()->user()->hasRole('Super Admin') ) {
            $metaDatas['page_on_front'] = $request->page_on_front ?? 1;
            $metaDatas['site_url'] = $request->site_url ?? null;
        }
        // add meta data as per form data

        // insert or update meta data
        foreach ($metaDatas as $key => $value) {
            $this->updateOrCreateMeta($payload, $key, $value);
        }
    }

    public function appearanceProcessMetaData($payload, $request)
    {
        $metaDatas = [];
        $metaDatas['additional_CSS'] = $request->additional_CSS ?? null;
        foreach ($metaDatas as $key => $value) {
            $this->updateOrCreateMeta($payload, $key, $value);
        }
    }

    // update Or insert data
    private function updateOrCreateMeta($setting, $key, $value)
    {
        $setting->updateOrInsert( ['setting_name' => $key], ['setting_value' => $value] );
    }
}
