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

        $db = config('akiforms.connection.akicategories', config('database.default'));

        $rows = Akicategory::on($db)->orderBy('cattype', 'ASC')->orderBy('name', 'ASC')->get();

        $data['rows'] = $rows;

		return view('akiforms::categories.index', $data);

	}

    public function create(){

        $data['centercolumn'] = 8;

        return view('akiforms::categories.create', $data);
                
    }

    public function store(Request $request){

        $db = config('akiforms.connection.akicategories', config('database.default'));

        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);

        $check = Akicategory::on($db)->where('slug', $request->input('slug'))->first();

        if(!empty($check)){

            return redirect()->back()->withInput()->with('message', 'The slug is already in use!');
        }

        $t = new Akicategory;

        $t->setConnection($db);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.categories.edit', [$t->id]);


    }

    public function edit($id){

        $db = config('akiforms.connection.akicategories', config('database.default'));

        $t = Akicategory::on($db)->find($id);

        if(empty($t)){

            return redirect()->route('aki.categories.index');

        }

        $data['centercolumn'] = 10;

        $data['item'] = $t;

        return view('akiforms::categories.update', $data);
                
    }

    public function update($id, Request $request){

        $db = config('akiforms.connection.akicategories', config('database.default'));

        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);

        $check = Akicategory::on($db)->where('slug', $request->input('slug'))->where('id', '!=', $id)->first();

        if(!empty($check)){

            return redirect()->back()->withInput()->with('message', 'The slug is already in use!');
        }

        $t = Akicategory::on($db)->find($id);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.categories.index')->with('pagemessage', 'The text block was saved.');
                
    }

    public function destroy($id, Request $request){



    }

}