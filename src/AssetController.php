<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akiasset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Image;

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

        $cats = Akicategory::selectoptions('asset');

        $data['cats'] = $cats;

        return view('akiforms::assets.create', $data);
                
    }

    public function store(Request $request){

        $nice = [

        ];

        $messages = [

        ];

        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ], $messages, $nice);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('pagemessage', 'Please fill out all required fields.');
        }

        $a = new Akiasset;

        $a->code = md5(time() . rand());

        $a->category = $request->input('category');
        
        $a->description = $request->input('description');

        $file = $request->file('file');

        $path = $file->store('public');

        $name = $request->input('name');

        if($name == ''){

            $name = $file->getClientOriginalName();
        }

        $a->name = $name;
               
        $a->serverfilename = $path;
        $a->filename = preg_replace("([^0-9a-zA-Z\-\.])", "", $file->getClientOriginalName());
        $a->mimetype = $file->getClientMimeType();
        $a->filesize = $file->getSize();

        switch($a->mimetype){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":


                $tn = 'public/tn_' . $file->hashName();

                $tnpath = storage_path('app/') . $tn;

                $image = Image::make(storage_path('app/') . $a->serverfilename);

                $image->fit(400, 400, function($constraint){

                    $constraint->upsize();

                })->orientate();

                $image->save($tnpath);

                $a->serverfilenametn = $tn;

                break;

        }

        $a->save();

        return redirect()->route('aki.asset.edit', [$t->id])->with('pagemessage', 'The file has been uploaded.');


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