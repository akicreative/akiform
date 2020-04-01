<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RedactorController extends Controller
{

	public function image(){

		echo "<pre>";
		print_r(config('app'));
		echo "</pre>";	
	}

}