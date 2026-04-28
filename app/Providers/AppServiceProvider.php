<?php

namespace App\Providers;

use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( app()->environment('production') ) {
            URL::forceScheme('https');
        }

        // global settings
        if (Schema::hasTable('settings')) {
            $settings = Cache::remember('app_settings', 10, function () {
                return SettingHelper::getModel()->pluck('setting_value', 'setting_name')->toArray();
            });

            View::share('settings', $settings);
        }
    }
}
