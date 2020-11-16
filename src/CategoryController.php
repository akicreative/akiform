<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;

class CategoryController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', route('aki.categories.index'));
        view()->share('akisubnavtitle', 'Categories');

        $akisubnav = [];

        $akisubnavform = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . action('\AkiCreative\AkiForms\CategoryController@create') . '" class="btn btn-secondary my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

        view()->share('akisubnavform', $akisubnavform);

	}

	public function index(){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $rows = Akicategory::on($db)->orderBy('cattype', 'ASC')->orderBy('name', 'ASC')->get();

        $data['rows'] = $rows;

		return view('akiforms::categories.index', $data);

	}

    public function create(){

        $data['centercolumn'] = 8;

        $cats = Akicategory::selectoptions('textblock');

        $data['cats'] = $cats;

        return view('akiforms::textblock.create', $data);
                
    }

    public function store(Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $t = new Akitextblock;

        $t->setConnection($db);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.textblock.edit', [$t->id]);


    }

    public function edit($id){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $t = Akitextblock::on($db)->find($id);

        if(empty($t)){

            return redirect()->route('aki.textblock.index');

        }

        $data['centercolumn'] = 10;

        $cats = Akicategory::selectoptions('textblock');

        $data['cats'] = $cats;

        $data['text'] = $t;

        return view('akiforms::textblock.update', $data);
                
    }

    public function update($id, Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $t = Akitextblock::on($db)->find($id);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.textblock.index')->with('pagemessage', 'The text block was saved.');
                
    }

    public function destroy($id, Request $request){



    }

}