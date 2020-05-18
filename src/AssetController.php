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

        view()->share('akisubnavurl', session('akisubnavurl', route('aki.asset.index')));
        view()->share('akisubnavtitle', session('akisubnavtitle', 'Assets'));

        $akisubnav = [];

        $akisubnav[] = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . route('aki.asset.create') . '" class="btn btn-secondary my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

	}

	public function index($focus = 'none'){

        if($focus != 'none'){

            $focuscategory = Akicategory::where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            if(request()->input('go') == 'filter'){

                session(['assetcategory' => request()->input('category')]);
        
            }

            $category = session('assetcategory', 'assetgeneral');

            $cats = Akicategory::selectoptions('asset');

            $data['cats'] = $cats;

            $data['focus'] = 'none';

        }else{

            $data['focus'] = $focus;

            $data['category'] = $focuscategory;

            $category = $focus;

            $akisubnav[] = '
            <form class="form-inline my-2 my-lg-0">
              <a href="' . route('aki.asset.category.create', $data['category']->slug) . '" class="btn btn-secondary my-2 my-sm-0">ADD</a>
            </form>
            ';

            $data['akisubnav'] = $akisubnav;
        }

        $rows = Akiasset::where('category', $category)->orderBy('created_at', 'DESC')->paginate(12);

        $data['rows'] = $rows;

		return view('akiforms::assets.index', $data);

	}

    public function create($focus = 'none'){

        $data['centercolumn'] = 8;

        if($focus != 'none'){

            $focuscategory = Akicategory::where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            $cats = Akicategory::selectoptions('asset');

            $data['cats'] = $cats;

            $data['focus'] = 'none';

        }else{

            $data['focus'] = $focus;

            $data['category'] = $focuscategory;

        }

        return view('akiforms::assets.create', $data);
                
    }

    public function store($focus = 'none', Request $request){

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

        if($focus == 'none'){

            $a->category = $request->input('category');
        
        }else{

            $a->category = $focus;

        }

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

                $image->resize(400, null, function($constraint){

                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->orientate();

                $image->save($tnpath);

                $a->serverfilenametn = $tn;

                break;

        }

        $a->save();

        if($focus == 'none'){

            return redirect()->route('aki.asset.edit', [$a->id])->with('pagemessage', 'The file has been uploaded.');

        }else{

            return redirect()->route('aki.asset.category.edit', [$focus, $a->id])->with('pagemessage', 'The file has been uploaded.');

        }


    }

    public function edit($id, $focus = 'none'){

        if($focus != 'none'){

            $focuscategory = Akicategory::where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            $cats = Akicategory::selectoptions('asset');

            $data['cats'] = $cats;
        
        }else{

            $data['focus'] = $focus;

            $data['category'] = $focuscategory;
        }

        $data['asset'] = Akiasset::find($id);

        $cat = Akicategory::where('slug', '=', $data['asset']->category)->first();

        $data['cat'] = $cat;

        return view('akiforms::assets.update', $data);
                
    }

    public function update($id, $category = 'none', Request $request){


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

    public function destroy($id, $category = 'none', Request $request){

        $a = Akiasset::find($id);

        if(empty($a)){

            return redirect()->route('aki.asset.index');
        }

        Storage::delete($a->serverfilename);

        Storage::delete($a->serverfilenametn);

        $a->delete();

        return redirect()->route('aki.asset.index')->with('pagemessage', 'The file has been deleted!');

    }

}