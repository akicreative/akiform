<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akitextblock;

class CmsController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', route('aki.cms'));
        view()->share('akisubnavtitle', 'Dashboard');

	}

	public function index(){

		return view('akiforms::cms.index');

	}

}