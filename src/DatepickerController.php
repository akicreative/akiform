<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DatepickerController extends Controller
{

	public function __construct()
	{


	}

	public function index(){

		echo "<pre>";
		print_r(time());
		echo "</pre>";	
	}

	public function calendar()
	{

		echo time();

	}

}