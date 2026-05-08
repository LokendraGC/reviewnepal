<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoutingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\SitemapController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/keep-session-alive', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

// artisan
Route::get('clear', function () {
    try {

        Artisan::call('optimize:clear');

        if (app()->environment('production')) Artisan::call('optimize');

        if (Auth::check()) {
            session()->flash('success', 'Cache and optimizations cleared.');
            return redirect()->back();
        } else {
            return response()->json(['success' => true, 'message' => 'Cache and optimizations cleared!']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'An error occurred while clearing the cache.'], 500);
    }
})->name('clear.cache');


// storage link
Route::get('storage', function () {
    Artisan::call('storage:link');
});

Route::get('/sitemap_index.xml', [SitemapController::class, 'index']);

Route::get('npreview-login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::get('reset-password/{token}', [AuthController::class, 'resetPassword']);

Route::group(['prefix' => 'test'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('/home', fn() => view('index'))->name('home');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});

require base_path('routes/sites.php');
