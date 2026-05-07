<?php

use App\Http\Controllers\Frontend\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\FrontController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\MigrateController;

// for home page
Route::get('/', [FrontController::class, 'index'])->name('home');

// if /home route to /
Route::get('/home', function () {
    return redirect('/');
})->name('home.redirect');


// migrate category 
Route::get('migrate-category', [MigrateController::class, 'migrateCategory'])->name('migrate.category');

// migrate post
Route::get('migrate-post', [MigrateController::class, 'migratePost'])->name('migrate.post');

// migrate user
Route::get('migrate-user', [MigrateController::class, 'migrateUser'])->name('migrate.user');

// category
Route::get('category/{category_slug}', [CategoryController::class, 'index'])->name('frontend.category.index');

// must be before catch-all `{slug}` so `/set-language` is not treated as a post slug
Route::post('set-language', [LanguageController::class, 'setLanguage'])->name('set.language');

// for all dynamic post and pages
Route::match(['get', 'post'], '{slug}', [PostController::class, 'index'])->name('frontend.post.index');

// for nepali post
Route::get('{year}/{month}/{id}', [PostController::class, 'index']) 
    ->name('frontend.post.index')
    ->where([
        'year' => '[0-9]{1,4}',
        'month' => '[0-9]{1,2}',
        'id' => '[0-9]+'
    ]);