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


});

