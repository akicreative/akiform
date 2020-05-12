<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akiasset;

class AssetController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', route('aki.asset.index'));
        view()->share('akisubnavtitle', 'Assets');

        $akisubnav = [];

        $akisubnav[] = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . route('aki.asset.create') . '" class="btn btn-secondary my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

	}

	public function index(){

        if(request()->input('go') == 'filter'){

            session(['assetcategory' => request()->input('category')]);
    
        }

        $category = session('assetcategory', 'assetgeneral');

        $cats = Akicategory::selectoptions('asset');

        $data['cats'] = $cats;

        $rows = Akiasset::where('category', $category)->orderBy('created_at', 'DESC')->get();

        $data['rows'] = $rows;

		return view('akiforms::assets.index', $data);

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

        $t = new Akitextblock;
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.textblock.edit', [$t->id]);


    }

    public function edit($id){

        $t = Akitextblock::find($id);

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

        $t = Akitextblock::find($id);
        
        $t->fill($request->all());

        $t->save();

        return redirect()->route('aki.textblock.index')->with('pagemessage', 'The text block was saved.');
                
    }

    public function destroy($id, Request $request){



    }

}