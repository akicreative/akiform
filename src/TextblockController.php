<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akitextblock;

class TextblockController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', '/cms/textblocks');
        view()->share('akisubnavtitle', 'Text Blocks');

        $akisubnav = [];

        $akisubnav[] = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . action('\AkiCreative\AkiForms\TextblockController@create') . '" class="btn btn-secondary my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

	}

	public function index(){


		return view('akiforms::textblock.index');

	}

    public function create(){

        $data['centercolumn'] = 8;

        $cats = Akicategory::selectoptions('textblock');

        $data['cats'] = $cats;

        return view('akiforms::textblock.create', $data);
                
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $t = new Textblock;
        
        $t->fill($request->all());

        $t->save();

        echo "SUCCESS";


    }

    public function edit($id){

        
                
    }

    public function update($id, Request $request){

        
                
    }

    public function destroy($id, Request $request){



    }

}