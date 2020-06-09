<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akiasset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Image;

class AssetController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', session('akisubnavurl', route('aki.asset.index')));
        view()->share('akisubnavtitle', session('akisubnavtitle', 'Assets'));

        $akisubnav = [];

        $akisubnavform = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . route('aki.asset.create') . '" class="btn btn-success my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);
        view()->share('akisubnavform', $akisubnavform);

	}

	public function index($focus = 'none', Request $request){

        if($request->input('savebutton') == 'order'){

            $orderby = $request->input('orderby');

            foreach($orderby as $key => $order){

                DB::table('akiform_assets')->where('id', '=', $key)->update(['orderby' => $order]);

            }

            if($focus == 'none'){

                return redirect()->route('aki.asset.index');

            }else{

                return redirect()->route('aki.asset.category.index', [$focus]);

            }

        }

        if($focus != 'none'){

            $focuscategory = Akicategory::where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            session()->forget('akisubnavtitle');

            session()->forget('akisubnavurl');

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

            $data['akisubnavtitle'] = session('akisubnavtitle', 'Assets');

            $data['akisubnavurl'] = session('akisubnavurl', route('aki.asset.index'));

            $akisubnav[] = '
             <li class="nav-item">
                <a class="nav-link" href="' . session('akisubnavurl', route('aki.asset.index')) . '">Return to Project</a>
             </li>
            ';

            $akisubnavform = '
            <form class="form-inline my-2 my-lg-0">
              <a href="' . route('aki.asset.category.create', $data['category']->slug) . '" class="btn btn-success my-2 my-sm-0">ADD</a>
            </form>
            ';

            $data['akisubnav'] = $akisubnav;

            $data['akisubnavform'] = $akisubnavform;
        }

        $rows = Akiasset::where('category', $category)->orderBy('orderby', 'ASC')->orderBy('created_at', 'DESC')->paginate(12);

        $data['rows'] = $rows;

		return view('akiforms::assets.index', $data);

	}

    public function create($focus = 'none'){

        if($focus != 'none'){

            $focuscategory = Akicategory::where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            $cats = Akicategory::selectoptions('asset');

            $data['cats'] = $cats;

            $categories = Akicategory::where('cattype', 'asset')->where('hidden', 0)->get();

            $data['categories'] = $categories;

            $data['focus'] = 'none';

        }else{

            $data['focus'] = $focus;

            $data['category'] = $focuscategory;

            $data['akisubnavtitle'] = session('akisubnavtitle', 'Assets');

            $data['akisubnavurl'] = session('akisubnavurl', route('aki.asset.index'));

            $akisubnav[] = '
             <li class="nav-item">
                <a class="nav-link" href="' . route('aki.asset.category.index', $data['category']->slug) . '">Return to Assets</a>
             </li>
            ';

            $data['akisubnav'] = $akisubnav;

            $data['akisubnavform'] = '';

            $categories = Akicategory::where('cattype', 'asset')->where('slug', $focus)->get();

            $data['categories'] = $categories;

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

        $assetcategory = Akicategory::where('slug', $a->category)->first();

        $tnresize = 'resize';
        $tnw = 480;
        $tnh = null;

        if(!empty($assetcategory)){

            $tnresize = $assetcategory->assettnresize;

            if($assetcategory->assettnw > 0){

                $tnw = $assetcategory->assettnw;
            
            }

            if($assetcategory->assettnh > 0){

                $tnh = $assetcategory->assettnh;
            
            }

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

                $image = Image::configure(array('driver' => 'imagick'))->make(storage_path('app/') . $a->serverfilename);

                if($tnresize == 'fit'){

                    $image->fit($tnw, $tnh, function($constraint){

                        $constraint->upsize();

                    })->orientate();

                }else{

                    $image->resize($tnw, $tnh, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate();

                }

                $image->save($tnpath);

                $a->serverfilenametn = $tn;

                break;

        }

        $last = Akiasset::where('category', $a->category)->orderBy('orderby', 'DESC')->first();

        if(empty($last)){

            $a->orderby = 1;
        }else{

            $a->orderby = $last->orderby + 1;
        }

        $a->save();

        if($focus == 'none'){

            return redirect()->route('aki.asset.edit', [$a->id])->with('pagemessage', 'The file has been uploaded.');

        }else{

            return redirect()->route('aki.asset.category.edit', [$a->id, $focus])->with('pagemessage', 'The file has been uploaded.');

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

            $data['focus'] = 'none';
        
        }else{

            $data['focus'] = $focus;

            $data['category'] = $focuscategory;

            $data['akisubnavtitle'] = session('akisubnavtitle', 'Assets');

            $data['akisubnavurl'] = session('akisubnavurl', route('aki.asset.index'));

            $akisubnav[] = '
             <li class="nav-item">
                <a class="nav-link" href="' . session('akisubnavurl', route('aki.asset.index')) . '">Return to Project</a>
             </li>
            ';

            $akisubnav[] = '
             <li class="nav-item">
                <a class="nav-link" href="' . route('aki.asset.category.index', $data['category']->slug) . '">Return to Assets</a>
             </li>
            ';

            $akisubnavform = '
            <form class="form-inline my-2 my-lg-0">
              <a href="' . route('aki.asset.category.create', $data['category']->slug) . '" class="btn btn-success my-2 my-sm-0">Add Asset</a>
            </form>

            ';

            $data['akisubnav'] = $akisubnav;

            $data['akisubnavform'] = $akisubnavform;
        }

        $data['asset'] = Akiasset::find($id);

        $cat = Akicategory::where('slug', '=', $data['asset']->category)->first();

        $data['cat'] = $cat;

        return view('akiforms::assets.update', $data);
                
    }

    public function update($id, $focus = 'none', Request $request){


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



                    $assetcategory = Akicategory::where('slug', $a->category)->first();

                    $tnresize = 'resize';
                    $tnw = 480;
                    $tnh = null;

                    if(!empty($assetcategory)){

                        $tnresize = $assetcategory->assettnresize;

                        if($assetcategory->assettnw > 0){

                            $tnw = $assetcategory->assettnw;
                        
                        }else{

                            $tnw = $tnw;
                        }

                        if($assetcategory->assettnh > 0){

                            $tnh = $assetcategory->assettnh;
                        
                        }else{

                            $tnh = $tnh;

                        }

                    }

                    Storage::delete($a->serverfilenametn);

                    $tn = 'public/tn_' . $file->hashName();

                    $tnpath = storage_path('app/') . $tn;

                    $image = Image::make(storage_path('app/') . $a->serverfilename);

                    if($tnresize == 'fit'){

                        $image->fit($tnw, $tnh, function($constraint){

                            $constraint->upsize();

                        })->orientate();

                    }else{

                        $image->resize($tnw, $tnh, function($constraint){

                            $constraint->aspectRatio();
                            $constraint->upsize();

                        })->orientate();

                    }

                    $image->save($tnpath);

                    $a->serverfilenametn = $tn;

                    break;

            }

        }

        $a->save();

        if($focus == 'none'){

            return redirect()->route('aki.asset.edit', [$a->id])->with('pagemessage', 'The file has been updated.');

        }else{

            return redirect()->route('aki.asset.category.edit', [$a->id, $focus])->with('pagemessage', 'The file has been updated.');


        }

        


    }

    public function destroy($id, $focus = 'none', Request $request){

        $a = Akiasset::find($id);

        if(empty($a)){

            return redirect()->route('aki.asset.index');
        }

        Storage::delete($a->serverfilename);

        Storage::delete($a->serverfilenametn);

        $a->delete();

        if($focus == 'none'){

            return redirect()->route('aki.asset.index')->with('pagemessage', 'The file has been deleted!');

        }else{

            return redirect()->route('aki.asset.category.index', [$focus])->with('pagemessage', 'The file has been deleted!');

        }

        

    }

}