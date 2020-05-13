<?

Route::prefix('akiforms')->middleware(['web'])->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('test23', 'RedactorController@image');


	Route::get('load/datepicker', 'DatepickerController@index')->name('akidatepicker');
	Route::post('load/datepicker/calendar', 'DatepickerController@calendar')->name('akidatepickercalendar');

});


Route::prefix('cms')->middleware(['web', 'isadmin'])->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('/textblocks', 'TextblockController@index')->name('aki.textblock.index');
	Route::get('/textblocks/create', 'TextblockController@create')->name('aki.textblock.create');
	Route::post('/textblocks/store', 'TextblockController@store')->name('aki.textblock.store');
	Route::get('/textblocks/{id}/edit', 'TextblockController@edit')->name('aki.textblock.edit');
	Route::post('/textblocks/{id}/update', 'TextblockController@update')->name('aki.textblock.update');

	Route::get('/assets', 'AssetController@index')->name('aki.asset.index');
	Route::get('/assets/create', 'AssetController@create')->name('aki.asset.create');
	Route::post('/assets/store', 'AssetController@store')->name('aki.asset.store');
	Route::get('/assets/{id}/edit', 'AssetController@edit')->name('aki.asset.edit');
	Route::post('/assets/{id}/update', 'AssetController@update')->name('aki.asset.update');
	Route::post('/assets/{id}/destroy', 'AssetController@destroy')->name('aki.asset.destroy');


});

