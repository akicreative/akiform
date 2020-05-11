<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TextblockController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', '/cms/textblocks');
        view()->share('akisubnavtitle', 'Text Blocks');

        $akisubnav = [];

        $akisubnav[] = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . action('TextblockController@create') . '" class="btn btn-secondary my-2 my-sm-0">ADD</a>
        </form>
        ';



	}

	public function index(){


		return view('akiforms::textblock.index');

	}

    public function create(){

        $data['centercolumn'] = 8;

        return view('akiforms::textblock.create', $data);
                
    }

    public function store($id, Request $request){

        
                
    }

    public function edit($id){

        
                
    }

    public function update($id, Request $request){

        
                
    }

    public function destroy($id, Request $request){



    }

}