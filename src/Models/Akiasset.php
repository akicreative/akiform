<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;
use AkiCreative\AkiForms\Models\Akiasset;
use AkiCreative\AkiForms\Models\Akicategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class Akiasset extends Model
{

	protected $table = 'akiform_assets';

	public function type(){

		switch($this->mimetype){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":

            	return "image";

            	break;

            case "applicaton/pdf":

            	return "pdf";

            	break;

        }

        return "file";

	}


    public function picture($cfgs = [])
    {

        $asset = $this;

        $cfg = [

            'sm' => '',
            'md' => '',
            'lg' => '',
            'custompath' => '',
            'imgonly' => false,
            'imgclass' => ''

        ];

        foreach($cfgs as $key => $value){

            $cfg[$key] = $value;
        }

        $path = asset('storage/' . $asset->serverfilename);
        $mdpath = asset('storage/' . $asset->serverfilename);
        $smpath = asset('storage/' . $asset->serverfilenametn);

        if($cfg['custompath'] != ''){

            $path = $cfg['custompath'] . $asset->serverfilename;
            $mdpath = $cfg['custompath'] . $asset->serverfilename;
            $smpath = $cfg['custompath'] . $asset->serverfilenametn;

        }

        ob_start();

        if(!$cfg['imgonly']){

            echo '<picture>';
            echo '<source media="(min-width: 650px)" srcset="' . $mdpath . '" ' . $cfg['md'] . '>';
            echo '<source media="(min-width: 465px)" srcset="' . $smpath . '" ' . $cfg['sm'] . '>';

        }

        echo '<img src="' . $path . '" class="img-fluid ' . $cfg['imgclass'] . '" alt="' . $asset->name . '"' . $cfg['lg'] . '>';

        if(!$cfg['imgonly']){

            echo '</picture>';

        }

        $output = ob_get_contents();

        ob_end_clean();

        return $output;

    }

    static public function assetadd($category, $file, $deleteid, $c = [])
    {

        $cfg = [];

        foreach($c as $key => $value){

            $cfg[$key] = $value;
        }

        $cat = Akicategory::where('slug', $category)->first();

        if(empty($cat)){

            return false;
        }

        if($cat->private){

            if(env('AKIASSETPRIVATE', '') == ''){

                die('Private Key not set');
            
            }else{

                $disk = env('AKIASSETPRIVATE');

            }

        }else{

            if(env('AKIASSETPUBLIC', '') == ''){

                die('Public Key not set');

            }else{

                $disk = env('AKIASSETPUBLIC');

            }
        }

        if(!$file){

            return false;
        }

        $hashname = $file->hashName();
        $mime = $file->getClientMimeType();
        $filename = $file->getClientOriginalName();
        $tn = '';

        switch($mime){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":

                $tn = 'tn_' . $hashname;

                $fullpath = Image::make($file)->resize($cat->assetw, $cat->asseth, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate()->save(storage_path('app/') . $hashname);

                $content = File::get(storage_path('app/') . $hashname);
                $result = Storage::disk($disk)->put($hashname, $content);

                if($cat->assettnresize == 'resize'){

                    $tnpath = Image::make($file)->resize($cat->assettnw, $cat->assettnh, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate()->save(storage_path('app/') . $tn);

                }else{

                    $tnpath = Image::make($file)->fit($cat->assettnw, $cat->assettnh, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate()->save(storage_path('app/') . $tn);

                }

                $content = File::get(storage_path('app/') . $tn);
                $result = Storage::disk($disk)->put($tn, $content);

                File::delete(storage_path('app/') . $hashname);
                File::delete(storage_path('app/') . $tn);

                break;
            default:

                echo $file->store('', $disk);

                break;

        }

        $a = new Akiasset;
        $a->code = md5(time() . rand());
        $a->category = $cat->slug;
        $a->serverfilename = $hashname;
        $a->serverfilenametn = $tn;
        $a->filename = $filename;
        $a->mimetype = $mime;
        $a->save();

        if($deleteid > 0){

            Akiasset::assetdelete($deleteid);
        }

        return $a;

    }

    static public function assetreplace($id, $file, $scope = 'both')
    {

        // Scope can be both, full, tn

        $a = Akiasset::find($id);

        if(empty($a)){

            return false;
        }

        $cat = Akicategory::where('slug', $a->category)->first();

        if($cat->private){

            if(env('AKIASSETPRIVATE', '') == ''){

                die('Private Key not set');
            
            }else{

                $disk = env('AKIASSETPRIVATE');

            }

        }else{

            if(env('AKIASSETPUBLIC', '') == ''){

                die('Public Key not set');

            }else{

                $disk = env('AKIASSETPUBLIC');

            }
        }

        if(!$file){

            return false;
        }

        $hashname = $file->hashName();
        $mime = $file->getClientMimeType();
        $filename = $file->getClientOriginalName();
        $tn = '';

        switch($mime){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":

                $tn = 'tn_' . $hashname;

                if($scope == 'both' || $scope == 'full'){

                    $fullpath = Image::make($file)->resize($cat->assetw, $cat->asseth, function($constraint){

                            $constraint->aspectRatio();
                            $constraint->upsize();

                        })->orientate()->save(storage_path('app/') . $hashname);

                    $content = File::get(storage_path('app/') . $hashname);
                    $result = Storage::disk($disk)->put($hashname, $content);

                    File::delete(storage_path('app/') . $hashname);

                }

                if($scope == 'both' || $scope == 'tn'){

                    if($cat->assettnresize == 'resize'){

                        $tnpath = Image::make($file)->resize($cat->assettnw, $cat->assettnh, function($constraint){

                            $constraint->aspectRatio();
                            $constraint->upsize();

                        })->orientate()->save(storage_path('app/') . $tn);

                    }else{

                        $tnpath = Image::make($file)->fit($cat->assettnw, $cat->assettnh, function($constraint){

                            $constraint->aspectRatio();
                            $constraint->upsize();

                        })->orientate()->save(storage_path('app/') . $tn);

                    }

                    $content = File::get(storage_path('app/') . $tn);
                    $result = Storage::disk($disk)->put($tn, $content);

                    File::delete(storage_path('app/') . $tn);

                }


                break;
            default:

                echo $file->store('', $disk);

                $scope = 'full';

                break;

        }

        if($scope == 'both' || $scope == 'full'){

            Storage::disk($disk)->delete($a->serverfilename);
            $a->serverfilename = $hashname;
        }

        if($scope == 'both' || $scope == 'tn'){

            Storage::disk($disk)->delete($a->serverfilenametn);
            $a->serverfilenametn = $tn;
        }
        
        $a->filename = $filename;
        $a->mimetype = $mime;
        $a->save();

        return $a;

    }

    static public function assetdelete($id)
    {

        $asset = Akiasset::find($id);

        if(empty($asset)){

            return false;
        }

        $cat = Akicategory::where('slug', $asset->category)->first();

        if($cat->private){

            if(env('AKIASSETPRIVATE', '') == ''){

                die('Private Key not set');
            
            }else{

                $disk = env('AKIASSETPRIVATE');

            }

        }else{

            if(env('AKIASSETPUBLIC', '') == ''){

                die('Public Key not set');

            }else{

                $disk = env('AKIASSETPUBLIC');

            }
        }

        Storage::disk($disk)->delete($asset->serverfilename);

        if($asset->serverfilenametn != ''){

            Storage::disk($disk)->delete($asset->serverfilenametn);

        }

        $asset->delete();

    }

}
