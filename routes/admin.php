<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\SummernoteController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\TrashController;
use App\Http\Controllers\Backend\AuthorController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\UserProfileController;
use App\Http\Controllers\Backend\GeneralSettingController;
use App\Http\Controllers\Backend\AppearanceSettingController;
use Illuminate\Support\Facades\Route;

Route::redirect('/npreview-backend', '/npreview-backend/dashboard')->middleware(['auth']);

Route::prefix('npreview-backend')->middleware(['auth', 'check.user.role'])->group(function () {

    // menu
    Route::get('menu', [MenuController::class, 'index'])->name('backend.menu');
    Route::get('menu/create', [MenuController::class, 'create'])->name('backend.menu.create');
    Route::post('menu', [MenuController::class, 'store'])->name('backend.menu.store');
    Route::get('menu/{id}/edit', [MenuController::class, 'edit'])->name('backend.menu.edit');
    Route::post('menu/{id}/edit', [MenuController::class, 'update'])->name('backend.menu.update');
    Route::get('menu/{id}/delete', [MenuController::class, 'destroy'])->name('backend.menu.delete');

    Route::get('menu/{id}/add-edit-menu-item', [MenuController::class, 'addEditMenuItems'])->name('backend.menu.add_edit_menu_item');
    Route::post('menu/{id}/add-edit-menu-item', [MenuController::class, 'updateEditMenuItems'])->name('backend.menu.update_edit_menu_item');

    // roles
    Route::get('role', [RoleController::class, 'index'])->name('backend.role');
    Route::get('role/create', [RoleController::class, 'create'])->name('backend.role.create');
    Route::post('role', [RoleController::class, 'store'])->name('backend.role.store');
    Route::get('role/{id}/edit', [RoleController::class, 'edit'])->name('backend.role.edit');
    Route::post('role/{id}/edit', [RoleController::class, 'update'])->name('backend.role.update');

    // permissions
    Route::get('permission', [PermissionController::class, 'index'])->name('backend.permission');
    Route::get('permission/create', [PermissionController::class, 'create'])->name('backend.permission.create');
    Route::post('permission', [PermissionController::class, 'store'])->name('backend.permission.store');
    Route::get('permission/{id}/edit', [PermissionController::class, 'edit'])->name('backend.permission.edit');
    Route::post('permission/{id}/edit', [PermissionController::class, 'update'])->name('backend.permission.update');

    // role to permission
    Route::get('role/{id}/give-permission', [RoleController::class, 'addPermissionToRole'])->name('addPermissionToRole');
    Route::post('role/{id}/give-permission', [RoleController::class, 'givePermissionToRole'])->name('givePermissionToRole');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

    // site settings
    Route::get('setting', [SettingController::class, 'index'])->name('backend.setting');
    Route::post('setting', [SettingController::class, 'store'])->name('backend.setting.store');

    Route::get('comment', [CommentController::class, 'index'])->name('backend.comment');
    Route::get('comment/{id}/edit', [CommentController::class, 'edit'])->name('backend.comment.edit');
    Route::post('comment/{id}/edit', [CommentController::class, 'update'])->name('backend.comment.update');
    Route::get('comment/{id}/delete', [CommentController::class, 'destroy'])->name('backend.comment.delete');

    // user routing
    Route::get('user', [UserController::class, 'index'])->name('backend.user');
    Route::get('user/create', [UserController::class, 'create'])->name('backend.user.create');
    Route::post('user', [UserController::class, 'store'])->name('backend.user.store');
    Route::get('user/profile/{id?}', [UserProfileController::class, 'profile'])->name('backend.user.profile');
    Route::post('user/profile/{id?}', [UserProfileController::class, 'store'])->name('backend.user.profile.store');
    Route::get('user/{user}/delete/view', [UserProfileController::class, 'deleteView'])->name('backend.user.delete.view');
    Route::post('user/{user}/delete', [UserProfileController::class, 'destroy'])->name('backend.user.delete');

    // password reset link
    Route::get('user/{user}/password-reset-link', [UserController::class, 'passwordResetLink'])->name('backend.user.passwordResetLink');

    // category routing
    Route::get('post/category', [CategoryController::class, 'index'])->name('backend.category');
    Route::post('post/category', [CategoryController::class, 'store'])->name('backend.category.store');
    Route::get('post/category/{id}/edit', [CategoryController::class, 'edit'])->name('backend.category.edit');
    Route::post('post/category/{id}/edit', [CategoryController::class, 'update'])->name('backend.category.update');
    Route::get('post/category/{id}/delete', [CategoryController::class, 'destroy'])->name('backend.category.delete');


    // category ne routing
    Route::get('post_ne/category', [CategoryController::class, 'index'])->name('backend.category_ne');
    Route::post('post_ne/category', [CategoryController::class, 'store'])->name('backend.category_ne.store');
    Route::get('post_ne/category/{id}/edit', [CategoryController::class, 'edit'])->name('backend.category_ne.edit');
    Route::post('post_ne/category/{id}/edit', [CategoryController::class, 'update'])->name('backend.category_ne.update');
    Route::get('post_ne/category/{id}/delete', [CategoryController::class, 'destroy'])->name('backend.category_ne.delete');


    // category routing
    Route::get('post/tag', [TagController::class, 'index'])->name('backend.tag');
    Route::post('post/tag', [TagController::class, 'store'])->name('backend.tag.store');
    Route::get('post/tag/{id}/edit', [TagController::class, 'edit'])->name('backend.tag.edit');
    Route::post('post/tag/{id}/edit', [TagController::class, 'update'])->name('backend.tag.update');
    Route::get('post/tag/{id}/delete', [TagController::class, 'destroy'])->name('backend.tag.delete');

    // post routing
    Route::get('post', [PostController::class, 'index'])->name('backend.post');
    Route::get('post/create', [PostController::class, 'create'])->name('backend.post.create');
    Route::post('post', [PostController::class, 'store'])->name('backend.post.store');
    Route::get('post/{id}/edit', [PostController::class, 'edit'])->name('backend.post.edit');
    Route::post('post/{id}/edit', [PostController::class, 'update'])->name('backend.post.update');
    Route::get('post/{id}/delete', [PostController::class, 'destroy'])->name('backend.post.delete');


    // post ne routing
    Route::get('post_ne', [PostController::class, 'index'])->name('backend.post_ne');
    Route::get('post_ne/create', [PostController::class, 'create'])->name('backend.post_ne.create');
    Route::post('post_ne', [PostController::class, 'store'])->name('backend.post_ne.store');
    Route::get('post_ne/{id}/edit', [PostController::class, 'edit'])->name('backend.post_ne.edit');
    Route::post('post_ne/{id}/edit', [PostController::class, 'update'])->name('backend.post_ne.update');
    Route::get('post_ne/{id}/delete', [PostController::class, 'destroy'])->name('backend.post_ne.delete');

    // soft deletes for posts
    Route::get('{type}/trash', [TrashController::class, 'index'])->name('backend.post.trash');
    Route::get('post/{id}/restore', [TrashController::class, 'restore'])->name('backend.post.restore');
    Route::get('post/{id}/delete-permanent', [TrashController::class, 'permanentlyDelete'])->name('backend.post.delete.permanant');

    // soft deletes for categories
    Route::get('category/{id}/restore', [TrashController::class, 'restoreCategory'])->name('backend.category.restore');
    Route::get('category/{id}/delete-permanent', [TrashController::class, 'permanentlyDeleteCategory'])->name('backend.category.delete.permanant');

    // pages routing
    Route::get('page', [PageController::class, 'index'])->name('backend.page');
    Route::get('page/create', [PageController::class, 'create'])->name('backend.page.create');
    Route::post('page', [PageController::class, 'store'])->name('backend.store.page');
    Route::get('page/{id}/edit', [PageController::class, 'edit'])->name('backend.page.edit');
    Route::post('page/{id}/edit', [PageController::class, 'update'])->name('backend.page.update');

    // general settings
    Route::get('general', [GeneralSettingController::class, 'index'])->name('backend.general.setting');
    Route::post('general', [GeneralSettingController::class, 'store'])->name('backend.general.setting.store');

    // appearance settings
    Route::get('appearance', [AppearanceSettingController::class, 'index'])->name('backend.appearance.setting');
    Route::post('appearance', [AppearanceSettingController::class, 'store'])->name('backend.appearance.setting.store');

    // author
    Route::get('post/author', [AuthorController::class, 'index'])->name('backend.author');
    Route::post('post/author', [AuthorController::class, 'store'])->name('backend.author.store');
    Route::get('post/author/{id}/edit', [AuthorController::class, 'edit'])->name('backend.author.edit');
    Route::post('post/author/{id}/edit', [AuthorController::class, 'update'])->name('backend.author.update');
    Route::get('post/author/{id}/delete', [AuthorController::class, 'destroy'])->name('backend.author.delete');

    // author nepali
    Route::get('post_ne/author', [AuthorController::class, 'index'])->name('backend.author_ne');
    Route::post('post_ne/author', [AuthorController::class, 'store'])->name('backend.author_ne.store');
    Route::get('post_ne/author/{id}/edit', [AuthorController::class, 'edit'])->name('backend.author_ne.edit');  
    Route::post('post_ne/author/{id}/edit', [AuthorController::class, 'update'])->name('backend.author_ne.update');
    Route::get('post_ne/author/{id}/delete', [AuthorController::class, 'destroy'])->name('backend.author_ne.delete');


    // pages routing
    Route::get('team', [TeamController::class, 'index'])->name('backend.team');
    Route::get('team/create', [TeamController::class, 'create'])->name('backend.team.create');
    Route::post('team', [TeamController::class, 'store'])->name('backend.store.team');
    Route::get('team/{id}/edit', [TeamController::class, 'edit'])->name('backend.team.edit');
    Route::post('team/{id}/edit', [TeamController::class, 'update'])->name('backend.team.update');

    // ajax
    Route::post('get-page-template', [PageController::class, 'getPageTemplate'])->name('backend.get.template');
    Route::post('get-edit-page-template', [PageController::class, 'getEditPageTemplate'])->name('backend.get.editTemplate');

    // ajax for menu
    Route::post('menu/{id}/add-edit-menu-item/sort', [MenuController::class, 'sortMenu'])->name('backend.menu.add_edit_menu_item.sort');
    Route::delete('menu/{menu_id}/delete/{item_id}', [MenuController::class, 'menuItemDelete'])->name('backend.menu.delete_item');
    Route::post('menu/menu-item-update/', [MenuController::class, 'menuItemUpdate'])->name('backend.menu.item_update');


    Route::post('remove-image', [SettingController::class, 'removeImage'])->name('backend.setting.removeImage');

    // Media Uploader
    Route::controller(MediaController::class)->group(function () {
        Route::get('/images', 'index')->name('getAllMedia');
        Route::post('get_file_by_ids', 'getPreviewFiles')->name('select.files');
    });

    Route::post('/temp-images', [MediaController::class, 'store'])->name('temp-images.create');
    Route::get('/load-more-media', [MediaController::class, 'loadMoreMedia'])->name('loadMoreMedia');

    Route::post('/summernote-upload', [SummernoteController::class, 'upload'])->name('summernote.image.upload');
});
