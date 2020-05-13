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

                $image->fit(400, null, function($constraint){

                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->orientate();

                $image->save($tnpath);

                $a->serverfilenametn = $tn;

                break;

        }

        $a->save();

        return redirect()->route('aki.asset.edit', [$a->id])->with('pagemessage', 'The file has been uploaded.');


    }

    public function edit($id){


        $data['asset'] = Akiasset::find($id);

        $cat = Akicategory::where('slug', '=', $data['asset']->category)->first();

        $data['cat'] = $cat;

        return view('akiforms::assets.update', $data);
                
    }

    public function update($id, Request $request){


        $a = Akiasset::find($id);

        $a->category = $request->input('category');
        
        $a->description = $request->input('description');

        if($request->hasFile('file')){

            Storage::delete($a->serverfilename);

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

                    Storage::delete($a->serverfilenametn);

                    $tn = 'public/tn_' . $file->hashName();

                    $tnpath = storage_path('app/') . $tn;

                    $image = Image::make(storage_path('app/') . $a->serverfilename);

                    $image->resize(400, null, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate();

                    $image->save($tnpath);

                    $a->serverfilenametn = $tn;

                    break;

            }

        }

        $a->save();

        return redirect()->route('aki.asset.edit', [$a->id])->with('pagemessage', 'The file has been updated.');


    }

    public function destroy($id, Request $request){

        $a = Akiasset::find($id);

        Storage::delete($a->serverfilename);

        Storage::delete($a->serverfilenametn);

        $a->delete();

        return redirect()->route('aki.asset.index', [$t->id])->with('pagemessage', 'The file has been deleted.');

    }

}