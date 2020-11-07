<?php

Route::middleware(['web'])->group(function(){

	Route::get('/asset/download/{id}/{filename}', 'AkiCreative\AkiForms\AssetController@getpublic')->name('aki.asset.public');

	Route::get('/asset/download/aws/{id}/{fn}', 'AkiCreative\AkiForms\AssetController@aws')->name('aki.asset.aws');

	Route::post('/ajax/akiforms/editor/upload', 'AkiCreative\AkiForms\AssetController@editorupload')->name('aki.editor.upload');

	Route::post('/ajax/akiforms/toast', 'AkiCreative\AkiForms\HomeController@toast')->name('aki.toast');

	Route::get('/telegram/login', 'AkiCreative\AkiForms\TelegramController@login')->name('aki.telegram.login');
	Route::get('/telegram/register', 'AkiCreative\AkiForms\TelegramController@register')->name('aki.telegram.register');
	Route::get('/telegram/auth', 'AkiCreative\AkiForms\TelegramController@auth')->name('aki.telegram.auth');

});

Route::prefix('akiforms')->middleware(['web'])->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('load/datepicker', 'DatepickerController@index')->name('akidatepicker');
	Route::post('load/datepicker/calendar', 'DatepickerController@calendar')->name('akidatepickercalendar');

});


Route::prefix('cms')->middleware(['web', 'isadmin'])->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('/', 'CmsController@index')->name('aki.cms');

	Route::get('/textblocks', 'TextblockController@index')->name('aki.textblock.index');
	Route::get('/textblocks/create', 'TextblockController@create')->name('aki.textblock.create');
	Route::post('/textblocks/store', 'TextblockController@store')->name('aki.textblock.store');
	Route::get('/textblocks/{id}/edit', 'TextblockController@edit')->name('aki.textblock.edit');
	Route::post('/textblocks/{id}/update', 'TextblockController@update')->name('aki.textblock.update');

	Route::get('/pages', 'PageController@index')->name('aki.page.index');
	Route::get('/pages/create', 'PageController@create')->name('aki.page.create');
	Route::post('/pages/store', 'PageController@store')->name('aki.page.store');
	Route::get('/pages/{id}/edit', 'PageController@edit')->name('aki.page.edit');
	Route::post('/pages/{id}/update', 'PageController@update')->name('aki.page.update');

	Route::get('/assets', 'AssetController@index')->name('aki.asset.index');
	Route::post('/assets', 'AssetController@index')->name('aki.asset.index');
	Route::get('/assets/create', 'AssetController@create')->name('aki.asset.create');
	Route::post('/assets/store', 'AssetController@store')->name('aki.asset.store');
	Route::get('/assets/{id}/edit', 'AssetController@edit')->name('aki.asset.edit');
	Route::post('/assets/{id}/update', 'AssetController@update')->name('aki.asset.update');
	Route::post('/assets/{id}/destroy', 'AssetController@destroy')->name('aki.asset.destroy');


	Route::get('/assets/{category}', 'AssetController@index')->name('aki.asset.category.index');
	Route::post('/assets/{category}', 'AssetController@index')->name('aki.asset.category.index');
	Route::get('/assets/{category}/create', 'AssetController@create')->name('aki.asset.category.create');
	Route::post('/assets/{category}/store', 'AssetController@store')->name('aki.asset.category.store');
	Route::get('/assets/{id}/{category}/edit', 'AssetController@edit')->name('aki.asset.category.edit');
	Route::post('/assets/{id}/{category}/update', 'AssetController@update')->name('aki.asset.category.update');
	Route::post('/assets/{id}/{category}/destroy', 'AssetController@destroy')->name('aki.asset.category.destroy');


});

