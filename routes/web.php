<?

Route::prefix('akiforms')->namespace('akicreative\akiforms')->group(function(){

	Route::get('test2', 'RedactorController@image');

});

