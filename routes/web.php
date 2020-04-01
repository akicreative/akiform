<?

Route::prefix('akiforms')->namespace('AkiCreative\AkiForms')->group(function(){

	Route::get('test2', 'RedactorController@image');

});

