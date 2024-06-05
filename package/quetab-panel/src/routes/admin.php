<?php

use Illuminate\Support\Facades\Route;
use Quetab\QuetabPanel\Controllers\Admin\AdminController;
use Quetab\QuetabPanel\Controllers\Admin\AdminUserController;
use Quetab\QuetabPanel\Controllers\Admin\AdminPageController;
use Quetab\QuetabPanel\Controllers\Admin\AdminSupportMessageController;
use Quetab\QuetabPanel\Controllers\Admin\AdminMediaController;
use Quetab\QuetabPanel\Controllers\Admin\AdminSettingController;

/**
 *
 * Admin Routes
 *
 */

// Load the prefixes from config
$urlPrefix = config('quetab.url_prefix');
$prefix = config('quetab.prefix');

Route::prefix("$urlPrefix")->as("$prefix.")->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    // Admin / Users
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/list/{order?}/{desc?}', [AdminUserController::class, 'index'])->name('index');
        Route::post('/create', [AdminUserController::class, 'filter'])->name('filter');
        Route::delete('/user/{id}', [AdminUserController::class, 'delete'])->name('delete');
        Route::get('/user/{id}', [AdminUserController::class, 'show'])->name('show');
        Route::put('/user/{id}', [AdminUserController::class, 'edit'])->name('edit');
        Route::post('/search', [AdminUserController::class, 'search'])->name('search');
        Route::get('/password/{id}/generate/password', [AdminUserController::class, 'generatePassword'])->name('generate.password');
        Route::get('/login/as/{id}', [AdminUserController::class, 'loginAs'])->name('login.as');
        Route::get('/ban/{id}', [AdminUserController::class, 'toggleBan'])->name('toggle.ban');
        //Route::post('/users/export/csv', [AdminUserController::class, 'exportUsers'])->name('export.users');
    });

    
    // Admin / Pages

    Route::prefix('pages')->as('pages.')->group(function () {
        Route::get('/list/{order?}/{desc?}', [AdminPageController::class, 'index'])->name('index');
        Route::get('/create/{id?}', [AdminPageController::class, 'create'])->name('create');
        Route::post('/create/{id?}', [AdminPageController::class, 'store'])->name('store');
        Route::delete('/page/{id}', [AdminPageController::class, 'delete'])->name('delete');
        Route::get('/page/{id}', [AdminPageController::class, 'show'])->name('show');
        Route::get('/info/{id}', [AdminPageController::class, 'get'])->name('get');
        Route::put('/page/{id}', [AdminPageController::class, 'edit'])->name('edit');
        Route::post('/search', [AdminPageController::class, 'search'])->name('search');
    });


    // Admin / Support Messages

    Route::prefix('messages')->as('messages.')->group(function () {
        Route::get('/list/{order?}/{desc?}', [AdminSupportMessageController::class, 'index'])->name('index');
        Route::post('/create', [AdminSupportMessageController::class, 'filter'])->name('filter');
        Route::delete('/message/{id}', [AdminSupportMessageController::class, 'delete'])->name('delete');
        Route::get('/message/{id}', [AdminSupportMessageController::class, 'show'])->name('show');
        Route::post('/search', [AdminSupportMessageController::class, 'search'])->name('search');
    });

    // Admin / Media
    Route::prefix('media')->as('media.')->group(function () {
        Route::get('/list/{order?}/{desc?}', [AdminMediaController::class, 'index'])->name('index');
        Route::post('/create', [AdminMediaController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [AdminMediaController::class, 'destroy'])->name('delete');
        Route::get('/file/{id}', [AdminMediaController::class, 'show'])->name('show');
        Route::put('/file/{id}', [AdminMediaController::class, 'edit'])->name('edit');
        Route::post('/search', [AdminMediaController::class, 'search'])->name('search');
    });


    // Admin / Settings
    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/list/{order?}/{desc?}', [AdminSettingController::class, 'index'])->name('index');
        Route::get('/create/{id?}', [AdminSettingController::class, 'create'])->name('create');
        Route::post('/create/{id?}', [AdminSettingController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [AdminSettingController::class, 'destroy'])->name('delete');
        Route::get('/setting/{id}', [AdminSettingController::class, 'show'])->name('show');
        Route::put('/setting/{id}', [AdminSettingController::class, 'edit'])->name('edit');
        Route::post('/search', [AdminSettingController::class, 'search'])->name('search');
    });
});
