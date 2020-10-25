<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akipage;

class PageController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', route('aki.page.index'));
        view()->share('akisubnavtitle', 'Pages');

        $akisubnav = [];

        $akisubnavform = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . action('\AkiCreative\AkiForms\PageController@create') . '" class="btn btn-success my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

        view()->share('akisubnavform', $akisubnavform);

	}

	public function index(){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $rows = Akipage::on($db)->orderBy('pagetitle', 'ASC')->get();

        $data['rows'] = $rows;

		return view('akiforms::pages.index', $data);

	}

    public function create(){

        $data['centercolumn'] = 8;

        return view('akiforms::pages.create', $data);
                
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'pagetitle' => 'required'
        ]);

        $t = new Akipage;

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $t->setConnection($db);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.page.edit', [$t->id]);


    }

    public function edit($id){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $p = Akipage::on($db)->find($id);

        if(empty($p)){

            return redirect()->route('aki.page.index');

        }

        $data['centercolumn'] = 10;

        $data['page'] = $p;

        return view('akiforms::pages.update', $data);
                
    }

    public function update($id, Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $p = Akipage::on($db)->find($id);
        
        $p->fill($request->all());

        $p->save();

        return redirect()->route('aki.page.index')->with('pagemessage', 'The page information was saved.');
                
    }

    public function destroy($id, Request $request){



    }

}