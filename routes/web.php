<?

Route::prefix('akiforms')->middleware(['web'])->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('test23', 'RedactorController@image');


	Route::get('load/datepicker', 'DatepickerController@index')->name('akidatepicker');
	Route::post('load/datepicker/calendar', 'DatepickerController@calendar')->name('akidatepickercalendar');

});


Route::prefix('cms')->middleware(['web', 'isadmin'])->namespace('AkiCreative\AkiForms')->group(function(){

	Route::resources([

		'textblocks' => 'TextblockController'


	]);


});

