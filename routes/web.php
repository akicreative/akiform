<?php

use AkiCreative\AkiForms\AssetController;
use AkiCreative\AkiForms\HomeController;
use AkiCreative\AkiForms\TelegramController;
use AkiCreative\AkiForms\DatepickerController;
use AkiCreative\AkiForms\CmsController;
use AkiCreative\AkiForms\TextblockController;
use AkiCreative\AkiForms\UserController;
use AkiCreative\AkiForms\PageController;
use AkiCreative\AkiForms\InfolistController;
use AkiCreative\AkiForms\CategoryController;

Route::middleware(['web'])->group(function () {
    Route::get('/asset/download/{id}/{filename}', [AssetController::class, 'getpublic'])->name('aki.asset.public');
    Route::get('/asset/download/aws/{id}/{fn}', [AssetController::class, 'aws'])->name('aki.asset.aws');
    Route::post('/ajax/akiforms/editor/upload', [AssetController::class, 'editorupload'])->name('aki.editor.upload');
    Route::post('/ajax/akiforms/toast', [HomeController::class, 'toast'])->name('aki.toast');
    Route::get('/telegram/login', [TelegramController::class, 'login'])->name('aki.telegram.login');
    Route::get('/telegram/register', [TelegramController::class, 'register'])->name('aki.telegram.register');
    Route::get('/telegram/auth', [TelegramController::class, 'auth'])->name('aki.telegram.auth');
});

Route::prefix('akiforms')->middleware(['web'])->group(function () {
    Route::get('load/datepicker', [DatepickerController::class, 'index'])->name('akidatepicker');
    Route::post('load/datepicker/calendar', [DatepickerController::class, 'calendar'])->name('akidatepickercalendar');
});

Route::prefix('cms')->middleware(['web', 'isadmin'])->group(function () {
    Route::get('/', [CmsController::class, 'index'])->name('aki.cms');

    Route::get('/textblocks', [TextblockController::class, 'index'])->name('aki.textblock.index');
    Route::get('/textblocks/create', [TextblockController::class, 'create'])->name('aki.textblock.create');
    Route::post('/textblocks/store', [TextblockController::class, 'store'])->name('aki.textblock.store');
    Route::get('/textblocks/{id}/edit', [TextblockController::class, 'edit'])->name('aki.textblock.edit');
    Route::post('/textblocks/{id}/update', [TextblockController::class, 'update'])->name('aki.textblock.update');

    Route::get('/users', [UserController::class, 'index'])->name('aki.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('aki.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('aki.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('aki.users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('aki.users.update');

    Route::get('/pages', [PageController::class, 'index'])->name('aki.page.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('aki.page.create');
    Route::post('/pages/store', [PageController::class, 'store'])->name('aki.page.store');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('aki.page.edit');
    Route::post('/pages/{id}/update', [PageController::class, 'update'])->name('aki.page.update');

    Route::get('/assets', [AssetController::class, 'index'])->name('aki.asset.index');
    Route::post('/assets', [AssetController::class, 'index']);
    Route::get('/assets/create', [AssetController::class, 'create'])->name('aki.asset.create');
    Route::post('/assets/store', [AssetController::class, 'store'])->name('aki.asset.store');
    Route::get('/assets/{id}/edit', [AssetController::class, 'edit'])->name('aki.asset.edit');
    Route::post('/assets/{id}/update', [AssetController::class, 'update'])->name('aki.asset.update');
    Route::post('/assets/{id}/destroy', [AssetController::class, 'destroy'])->name('aki.asset.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('aki.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('aki.categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('aki.categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('aki.categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('aki.categories.update');

    Route::get('/lists', [InfolistController::class, 'index'])->name('aki.lists.index');
    Route::post('/lists/store', [InfolistController::class, 'store'])->name('aki.lists.store');
    Route::get('/lists/{id}', [InfolistController::class, 'edit'])->name('aki.lists.edit');
    Route::post('/lists/{id}/update', [InfolistController::class, 'update'])->name('aki.lists.save');
    Route::post('/lists/orderby', [InfolistController::class, 'orderby'])->name('aki.lists.orderby');
    Route::post('/lists/{id}/destroy', [InfolistController::class, 'destroy'])->name('aki.lists.destroy');
});
