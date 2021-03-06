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

        view()->share('cats', Akicategory::selectoptions('textblock'));

        view()->share('akisubnavurl', route('aki.textblock.index'));
        view()->share('akisubnavtitle', 'Text Blocks');

        $akisubnav = [];

        $akisubnavform = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . action('\AkiCreative\AkiForms\TextblockController@create') . '" class="btn btn-success btn-sm my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

        view()->share('akisubnavform', $akisubnavform);

	}

	public function index(){

        if(request()->input('go') == 'filter'){

            session(['textblockcategory' => request()->input('category', 'all')]);

        }

        $category = session('textblockcategory', 'all');

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $rows = Akitextblock::on($db);

        if($category != 'all'){

            $rows->where('category', $category);
        }

        $rows = $rows->orderBy('category', 'ASC')->orderBy('name', 'ASC')->get();

        $data['rows'] = $rows;

		return view('akiforms::textblock.index', $data);

	}

    public function create(){

        $data['centercolumn'] = 8;

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