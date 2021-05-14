<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akiasset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Image;

class AssetController extends Controller
{

    private function target($private = true)
    {

        if($private){

            return env('AKIASSETPRIVATE', 'local');
        }

        return env('AKIASSETPUBLIC', 'local');

    }

	public function __construct()
	{

        view()->share('akisubnavurl', route('aki.asset.index'));
        view()->share('akisubnavtitle', 'Assets');

        $akisubnav = [];

        $akisubnav[] = '

          <li class="nav-item">
        <a class="nav-link" href="' . route('aki.categories.index') . '">Category Management</a>
      </li>

        ';

        $akisubnavform = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . route('aki.asset.create') . '" class="btn btn-success my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);
        view()->share('akisubnavform', $akisubnavform);

        

	}

	public function index($focus = 'none', Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        if($request->input('savebutton') == 'order'){

            $orderby = $request->input('orderby');

            foreach($orderby as $key => $order){

                DB::table('akiform_assets')->connection($db)->where('id', '=', $key)->update(['orderby' => $order]);

            }

            if($focus == 'none'){

                return redirect()->route('aki.asset.index');

            }else{

                return redirect()->route('aki.asset.category.index', [$focus]);

            }

        }

        if($focus != 'none'){

            $focuscategory = Akicategory::on($db)->where("slug", $focus)->first();

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

        $rows = Akiasset::on($db)->where('category', $category)->orderBy('orderby', 'ASC')->orderBy('created_at', 'DESC')->paginate(12);

        $data['rows'] = $rows;

		return view('akiforms::assets.index', $data);

	}

    public function create($focus = 'none'){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        if($focus != 'none'){

            $focuscategory = Akicategory::on($db)->where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            $cats = Akicategory::selectoptions('asset');

            $data['cats'] = $cats;

            $categories = Akicategory::on($db)->where('cattype', 'asset')->where('hidden', 0)->get();

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

            $categories = Akicategory::on($db)->where('cattype', 'asset')->where('slug', $focus)->get();

            $data['categories'] = $categories;

        }

        return view('akiforms::assets.create', $data);
                
    }

    public function store($focus = 'none', Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

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

        if($focus == 'none'){

            $category = $request->input('category');
        
        }else{

            $category = $focus;

        }

        $assetcategory = Akicategory::on($db)->where('slug', $category)->first();

        if($assetcategory->private){

            $visibility = 'private';

        }else{

            $visibility = 'public';

        }

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

        

        $file = $request->file('file');

        $target = $this->target($assetcategory->private);

        if($target != 'local'){

            $asset = akiassetadd($category, $file);

            $asset->name = $request->input('name');
            $asset->description = $request->input('description');

            $last = Akiasset::on($db)->where('category', $category)->orderBy('orderby', 'DESC')->first();

            if(empty($last)){

                $asset->orderby = 1;
            }else{

                $asset->orderby = $last->orderby + 1;
            }

            $asset->save();

            $assetid = $asset->id;

        }else{

            $a = new Akiasset;

            $a->setConnection($db);

            $a->code = md5(time() . rand());

            $a->description = $request->input('description');
            
            if($assetcategory->private){

                $path = $file->store('private');

            }else{

                $path = $file->store('public');

            }

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

                    if($target != 'local'){

                        $tn = 'tn_' . $file->hashName();

                    }else{

                        if($assetcategory->private){

                            $tn = 'private/tn_' . $file->hashName();

                        }else{

                            $tn = 'public/tn_' . $file->hashName();

                        }

                    }

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

            $last = Akiasset::on($db)->where('category', $a->category)->orderBy('orderby', 'DESC')->first();

            if(empty($last)){

                $a->orderby = 1;
            }else{

                $a->orderby = $last->orderby + 1;
            }

            $a->domain = $_SERVER['HTTP_HOST'];

            $a->save();

            $assetid = $a->id;

        }

        

        if(false){

            $filelocation = storage_path('app/') . $a->serverfilename;
            $filelocationtn = storage_path('app/') . $a->serverfilenametn;

            $content = File::get($filelocation);
            $result = Storage::disk($target)->put($a->serverfilename, $content);

            /*

            if($visibility == 'public'){

                Storage::disk($target)->setVisibility($a->serverfilename, 'public');
            }

            */

            File::delete($filelocation);

            if($a->serverfilenametn != ''){

                $content = File::get($filelocationtn);
                $result = Storage::disk($target)->put($a->serverfilenametn, $content);

                File::delete($filelocationtn);

                /*

                if($visibility == 'public'){

                    Storage::disk($target)->setVisibility($a->serverfilenametn, 'public');
                }

                */

            }

        }

        if($focus == 'none'){

            return redirect()->route('aki.asset.edit', [$assetid])->with('pagemessage', 'The file has been uploaded.');

        }else{

            return redirect()->route('aki.asset.category.edit', [$assetid, $focus])->with('pagemessage', 'The file has been uploaded.');

        }


    }

    public function edit($id, $focus = 'none'){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $asset = Akiasset::on($db)->find($id);

        $cat = Akicategory::on($db)->where('slug', '=', $asset->category)->first();

        if($focus != 'none'){

            $focuscategory = Akicategory::on($db)->where("slug", $focus)->first();

            if(empty($focuscategory)){

                $focus = 'none';
            }

        }

        if($focus == 'none'){

            session()->forget('akisubnavtitle');

            session()->forget('akisubnavurl');

            $cats = Akicategory::selectoptions('asset', true, $cat->private);

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

        $data['asset'] = $asset;

        $data['cat'] = $cat;

        return view('akiforms::assets.update', $data);
                
    }

    public function update($id, $focus = 'none', Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $a = Akiasset::on($db)->find($id);

        $a->category = $request->input('category');
        $a->name = $request->input('name');
        $a->description = $request->input('description');

        $assetcategory = Akicategory::on($db)->where('slug', $a->category)->first();

        if($request->hasFile('file')){

            akiassetreplace($a->id, $request->file('file'));
        }

        /*

        $target = $this->target($assetcategory->private);



        if($assetcategory->private){

            $visibility = 'private';

        }else{

            $visibility = 'public';

        }

        if($request->hasFile('file')){

            if($target == 'local'){

                Storage::delete($a->serverfilename);

            }else{

                Storage::disk($target)->delete($a->serverfilename);
            }

            $file = $request->file('file');

            if($target != 'local'){

                $path = $file->store('');

            }else{

                if($assetcategory->private){

                    $path = $file->store('private');

                    $visibility = 'private';

                }else{

                    $path = $file->store('public');

                    $visibility = 'public';

                }

            }

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

                    if($target == 'local'){

                        Storage::delete($a->serverfilenametn);

                    }else{

                        Storage::disk($target)->delete($a->serverfilenametn);
                    }

                    if($target != 'local'){

                        $tn = 'tn_' . $file->hashName();

                    }else{

                        if($assetcategory->private){

                            $tn = 'private/tn_' . $file->hashName();

                        }else{

                            $tn = 'public/tn_' . $file->hashName();

                        }

                    }

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

        */

        $a->save();

        /*

        if($target != 'local'){

            $filelocation = storage_path('app/') . $a->serverfilename;
            $filelocationtn = storage_path('app/') . $a->serverfilenametn;

            $content = File::get($filelocation);
            $result = Storage::disk($target)->put($a->serverfilename, $content);

            File::delete($filelocation);

            /*

            if($visibility == 'public'){

                Storage::disk($target)->setVisibility($a->serverfilename, 'public');
            }

            */

            /*

            if($a->serverfilenametn != ''){

                $content = File::get($filelocationtn);
                $result = Storage::disk($target)->put($a->serverfilenametn, $content);

                File::delete($filelocationtn);

               

            }

        }

        */



        if($focus == 'none'){

            return redirect()->route('aki.asset.edit', [$a->id])->with('pagemessage', 'The file has been updated.');

        }else{

            return redirect()->route('aki.asset.category.edit', [$a->id, $focus])->with('pagemessage', 'The file has been updated.');


        }

    }

    public function destroy($id, $focus = 'none', Request $request){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $a = Akiasset::on($db)->find($id);

        if(empty($a)){

            return redirect()->route('aki.asset.index');
        }

        $assetcategory = Akicategory::on($db)->where('slug', $a->category)->first();

        $target = $this->target($assetcategory->private);

        if($target == 'local'){

            Storage::delete($a->serverfilename);

            Storage::delete($a->serverfilenametn);

             $a->delete();

        }else{

            akiassetdelete($a->id);
        }

       

        if($focus == 'none'){

            return redirect()->route('aki.asset.index')->with('pagemessage', 'The file has been deleted!');

        }else{

            return redirect()->route('aki.asset.category.index', [$focus])->with('pagemessage', 'The file has been deleted!');

        }

        

    }

    public function getpublic($id, $filename)
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $a = Akiasset::on($db)->where('id', $id)->where('serverfilename',  'public/' . $filename)->first();

        $filepath = '';

        if(empty($a)){

            $a = Akiasset::on($db)->where('id', $id)->where('serverfilenametn', 'public/' .  $filename)->first();

            $filepath = storage_path('app') . '/' . $a->serverfilenametn;
            
        }else{

            $filepath = storage_path('app') . '/' . $a->serverfilename;
        }

        if(empty($a)){

            abort(404);
        }

        $c = Akicategory::on($db)->where('slug', $a->category)->first();

        if($c->private){

            abort(404);
        }

        switch($a->type()){

            case "image":

                return response()->file($filepath, ['Content-Type' => $a->mimetype]);

                break;

            case "pdf":

                return response()->file($filepath, $a->filename, ['Content-Type' => $a->mimetype]);

                break;

            default:

                return response()->download($filepath, $a->filename, ['Content-Type' => $a->mimetype]);

                break;

        }
        
    }

    public function getprivate($id, $filename)
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $a = Akiasset::db($db)->where('id', $id)->where('serverfilename', 'private/' . $filename)->first();

        $filepath = '';

        if(empty($a)){

            $a = Akiasset::on($db)->where('id', $id)->where('serverfilenametn', 'private/' .  $filename)->first();

            $filepath = storage_path('app') . '/' . $a->serverfilenametn;
            
        }else{

            $filepath = storage_path('app') . '/' . $a->serverfilename;
        }

        if(empty($a)){

            abort(404);
        }

        $c = Akicategory::on($db)->where('slug', $a->category)->first();

        switch($a->type()){

            case "image":

                return response()->file($filepath, ['Content-Type' => $a->mimetype]);

                break;

            case "pdf":

                return response()->file($filepath, $a->filename, ['Content-Type' => $a->mimetype]);

                break;

            default:

                return response()->download($filepath, $a->filename, ['Content-Type' => $a->mimetype]);

                break;

        }
        
    }

    public function aws($id, $filename)
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $a = Akiasset::on($db)->where('id', $id)->where('serverfilename', $filename)->first();

        $c = Akicategory::on($db)->where('slug', $a->category)->first();

        $scope = 'public';

        $target = env('AKIASSETPUBLIC', 'local');

        if($c->private){

            $scope = 'private';

            $target = env('AKIASSETPRIVATE', 'local');
        }

        if($target != 'local'){

            return Storage::disk($target)->download($a->serverfilename, $a->filename);

        }

        if($scope == 'public'){

            $url = Storage::disk($target)->url($a->serverfilename);

        }else{

            $url = Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(15));
        }

        return response()->streamDownload(function(){

            echo file_get_contents($url); 

        }, $a->filename);

    }

    public function editorupload(Request $request)
    {  

        $files = [];

        $return = [];

        if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                
                $asset = akiassetadd('asseteditor', $file);

                $url = akiasseturl($asset->id);

                $files[] = [

                    'url' => $url,
                    'id' => $asset->id

                ];


            }

            if(count($files) == 0){

                return response()->json(['error' => true, 'message' => 'File Not Uploaded']);
            }


            if(count($files) > 1){

                $counter = 1;

                foreach($files as $f){

                    $key = 'file-' . $counter;

                    $return[$key] = $f;

                }

            }else{

                $return['file'] = $files[0];
            }

            return response()->json($return);

        }else{

            return response()->json(['error' => true, 'message' => 'File Not Uploaded']);
        }

    }

}