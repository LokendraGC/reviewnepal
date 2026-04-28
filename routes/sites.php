<?php

use App\Http\Controllers\Frontend\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\FrontController;

// for home page
Route::get('/', [FrontController::class, 'index'])->name('home');

// if /home route to /
Route::get('/home', function () {
    return redirect('/');
})->name('home.redirect');

// category
Route::get('category/{category_slug}', [CategoryController::class, 'index'])->name('frontend.category.index');

// for all dynamic post and pages
Route::match(['get', 'post'], '{slug}', [PostController::class, 'index'])->name('frontend.post.index');
