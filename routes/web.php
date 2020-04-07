<?

Route::prefix('akiforms')->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('test23', 'RedactorController@image');


	Route::get('load/datepicker', 'DatepickerController@index')->name('akidatepicker');

});

