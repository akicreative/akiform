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

        view()->share('akisubnavurl', route('textblocks.index'));
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

        $rows = Akitextblock::orderBy('category', 'ASC')->orderBy('name', 'ASC')->get();

        $data['rows'] = $rows;

		return view('akiforms::textblock.index', $data);

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

        return redirect()->route('textblocks.edit', [$t->id]);


    }

    public function edit($id){

        $t = Akitextblock::find($id);

        if(empty($t)){

            return redirect()->route('textblocks.index');

        }

        $data['text'] = $t;

        return view('akiforms::textblock.update');
                
    }

    public function update($id, Request $request){

        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $t = Akitextblock::find($id);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('textblocks.index')->with('pagemessage', 'The text block was saved.');
                
    }

    public function destroy($id, Request $request){



    }

}