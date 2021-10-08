<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use AkiCreative\AkiForms\Models\Akiasset;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akisubcategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class Akiasset extends Model
{

    use Notifiable;

	protected $table = 'akiform_assets';

	public function type(){

		switch($this->mimetype){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":

            	return "image";

            	break;

            case "image/gif":
                return 'gif';
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

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $target = env('AKIASSETPUBLIC', 'local');

        if($target != 'local'){

            $path = $asset->url('full');
            $mdpath = $asset->url('full');
            $smpath = $asset->url('tn');


        }else{

            $path = asset('storage/' . $asset->serverfilename);
            $mdpath = asset('storage/' . $asset->serverfilename);
            $smpath = asset('storage/' . $asset->serverfilenametn);

            if($cfg['custompath'] != ''){

                $path = $cfg['custompath'] . $asset->serverfilename;
                $mdpath = $cfg['custompath'] . $asset->serverfilename;
                $smpath = $cfg['custompath'] . $asset->serverfilenametn;

            }

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

    public function url($mode = 'full', $auth = false)
    {

        $a = $this;

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $c = \AkiCreative\AkiForms\Models\Akicategory::on($db)->where('slug', $a->category)->first();

        $scope = 'public';

        $target = env('AKIASSETPUBLIC', 'local');

        if($c->private){

            $scope = 'private';

            $target = env('AKIASSETPRIVATE', 'local');
        }

        if($scope == 'private' && !$auth){

            return '#';
        }

        if($target != 'local'){

            if($a->type() == "image" || $a->type() == 'gif'){

                if($mode == 'full' || $a->type() == 'gif'){

                    if($scope == 'public'){

                        return Storage::disk($target)->url($a->serverfilename);

                    }else{

                        return Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(5));
                    }

                }elseif($mode == 'sq' && $a->serverfilenamesq != ''){

                    if($scope == 'public'){

                        return Storage::disk($target)->url($a->serverfilenamesq);

                    }else{

                        return Storage::disk($target)->temporaryUrl($a->serverfilenamesq, now()->addMinutes(5));
                    }

                }else{

                    if($scope == 'public'){

                        return Storage::disk($target)->url($a->serverfilenametn);

                    }else{

                        return Storage::disk($target)->temporaryUrl($a->serverfilenametn, now()->addMinutes(5));
                    }
                }

            }else{

                return route('aki.asset.aws', [$a->id, $a->serverfilename]);

            }


        }else{

            if($mode == 'full' || $a->type() != 'image'){

                $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilename);

                return route('aki.asset.' . $scope, [$id, $fn]);
            
            }else{

                $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilenametn);

                return route('aki.asset.' . $scope, [$id, $fn]);

            }

        }

    }

    static public function assetadd($category, $file, $deleteid, $c = [])
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $cfg = ['subcategory' => NULL, 'addsubcategory' => NULL];

        foreach($c as $key => $value){

            $cfg[$key] = $value;
        }

        $cat = Akicategory::on($db)->where('slug', $category)->first();

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

        $folder = '';

        if(in_array($disk, ['spaces', 'spacesprivate'])){

            $folder = config('filesystems.disks.' . $disk . '.folder', '');

            if($folder != '') $folder = $folder . '/';
        }

        if(is_string($file)){

            if(File::exists($file)){

                if(array_key_exists('path', $cfg)){

                    $folder = $cfg['path'] . '/';
                }

                $content = File::get($file);

                $mimeclass = new \Symfony\Component\Mime\MimeTypes;

                $mime = $mimeclass->guessMimeType($file);

                $ext = pathinfo($file, PATHINFO_EXTENSION);

                $hashname = Str::orderedUuid() . '.' . $ext;

                $serverfilename = $folder . $hashname;

                $filename = pathinfo($file, PATHINFO_FILENAME) . '.' . $ext;

                $result = Storage::disk($disk)->put($serverfilename, $content);

                $a = new Akiasset;

                $a->setConnection($db);
                $a->code = md5(time() . rand());
                $a->category = $cat->slug;
                $a->serverfilename = $serverfilename;
                $a->filename = $filename;
                $a->mimetype = $mime;

                if($cfg['addsubcategory'] != NULL){

                    $slug = $category . '-' . Str::of($cfg['addsubcategory'])->slug('');

                    $subcat = Akisubcategory::connection($db)->where('category', $category)->where('slug', $slug)->first();

                    if(empty($subcat)){

                        $subcat = new Akisubcategory;
                        $subcat->setConnection($db);
                        $subcat->slug = $slug;
                        $subcat->category = $category;
                        $subcat->name = $cfg['addsubcategory'];
                        $subcat->save();

                        $a->subcategory = $slug;
                    }else{

                        $a->subcategory = $subcat->slug;
                    }

                    
                }elseif($cfg['subcategory'] != NULL){

                    $subcat = Akisubcategory::connection($db)->where('category', $category)->where('slug', $cfg['subecategory'])->first();

                    if(!empty($subcat)){

                        $a->subcategory = $subcat->slug;

                    }

                }

                $a->save();

                if($deleteid > 0){

                    Akiasset::assetdelete($deleteid);
                }

                return $a;

            }else{

                return false;
            }

        }else{

            if(!$file){

                return false;
            }

            $hashname = $file->hashName();
            $mime = $file->getClientMimeType();
            $filename = $file->getClientOriginalName();

        }

        $tn = '';
        $sq = '';

        $type = '';

        switch($mime){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":

                $tn = 'tn_' . $hashname;
                $sq = 'sq_' . $hashname;

                $fullpath = Image::make($file)->resize($cat->assetw, $cat->asseth, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate()->save(storage_path('app/') . $hashname);

                $content = File::get(storage_path('app/') . $hashname);
                $result = Storage::disk($disk)->put($folder . $hashname, $content);

                //if($cat->assettnresize == 'resize'){

                    $tnpath = Image::make($file)->resize($cat->assettnw, null, function($constraint){

                        $constraint->aspectRatio();
                        $constraint->upsize();

                    })->orientate()->save(storage_path('app/') . $tn);

                //}else{

                    $sqpath = Image::make($file)->fit($cat->assetsqw, $cat->assetsqh, function($constraint){

                        $constraint->upsize();

                    })->orientate()->save(storage_path('app/') . $sq);

                //}

                $content = File::get(storage_path('app/') . $tn);
                $result = Storage::disk($disk)->put($folder . $tn, $content);

                $content = File::get(storage_path('app/') . $sq);
                $result = Storage::disk($disk)->put($folder . $sq, $content);

                File::delete(storage_path('app/') . $hashname);
                File::delete(storage_path('app/') . $tn);
                File::delete(storage_path('app/') . $sq);

                $type = 'image';

                break;

            case "image/gif":

                $folderonly = '';

                if(in_array($disk, ['spaces', 'spacesprivate'])){

                    $folderonly = config('filesystems.disks.' . $disk . '.folder', '');

                    $file->storeAs($folderonly, $hashname, $disk);

                }else{

                    $file->storeAs('', $hashname, $disk);

                }

                break;

            default:

                $folderonly = '';

                if(in_array($disk, ['spaces', 'spacesprivate'])){

                    $folderonly = config('filesystems.disks.' . $disk . '.folder', '');

                    $file->storeAs($folderonly, $hashname, $disk);

                }else{

                    $file->storeAs('', $hashname, $disk);


                
                }

                $scope = 'full';

                break;

        }

        $a = new Akiasset;

        $a->setConnection($db);
        $a->code = md5(time() . rand());
        $a->category = $cat->slug;
        $a->serverfilename = $folder . $hashname;

        if($type == 'image'){

            $a->serverfilenametn = $folder . $tn;
            $a->serverfilenamesq = $folder . $sq;

        }

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

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $a = Akiasset::on($db)->find($id);

        if(empty($a)){

            return false;
        }

        $cat = Akicategory::on($db)->where('slug', $a->category)->first();

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

        $folder = '';

        if(in_array($disk, ['spaces', 'spacesprivate'])){

            $folder = config('filesystems.disks.' . $disk . '.folder', '');

            if($folder != '') $folder = $folder . '/';
        }

        if(!$file){

            return false;
        }

        $hashname = $file->hashName();
        $mime = $file->getClientMimeType();
        $filename = $file->getClientOriginalName();
        $tn = '';
        $sq = '';

        switch($mime){

            case "image/jpeg":
            case "image/png":
            case "image/jpg":

                $tn = 'tn_' . $hashname;
                $sq = 'sq_' . $hashname;

                if($scope == 'both' || $scope == 'full'){

                    $fullpath = Image::make($file)->resize($cat->assetw, $cat->asseth, function($constraint){

                            $constraint->aspectRatio();
                            $constraint->upsize();

                        })->orientate()->save(storage_path('app/') . $hashname);

                    $content = File::get(storage_path('app/') . $hashname);
                    $result = Storage::disk($disk)->put($folder . $hashname, $content);

                    File::delete(storage_path('app/') . $hashname);

                }

                if($scope == 'both' || $scope == 'tn'){

                    //if($cat->assettnresize == 'resize'){

                        $tnpath = Image::make($file)->resize($cat->assettnw, null, function($constraint){

                            $constraint->aspectRatio();
                            $constraint->upsize();

                        })->orientate()->save(storage_path('app/') . $tn);

                    //}else{

                        $sqpath = Image::make($file)->fit($cat->assetsqw, $cat->assetsqh, function($constraint){

                            $constraint->upsize();

                        })->orientate()->save(storage_path('app/') . $sq);

                    //}

                    $content = File::get(storage_path('app/') . $tn);
                    $result = Storage::disk($disk)->put($folder . $tn, $content);

                    $content = File::get(storage_path('app/') . $sq);
                    $result = Storage::disk($disk)->put($folder . $sq, $content);

                    File::delete(storage_path('app/') . $tn);

                }


                break;

            case "image/gif":

                $folderonly = '';

                if(in_array($disk, ['spaces', 'spacesprivate'])){

                    $folderonly = config('filesystems.disks.' . $disk . '.folder', '');

                    $file->storeAs($folderonly, $hashname, $disk);

                }else{

                    $file->storeAs('', $hashname, $disk);
                
                }

                break;

            default:

                $folderonly = '';

                if(in_array($disk, ['spaces', 'spacesprivate'])){

                    $folderonly = config('filesystems.disks.' . $disk . '.folder', '');

                    $file->storeAs($folderonly, $hashname, $disk);

                }else{



                    $file->storeAs('', $hashname, $disk);

                }

                $scope = 'full';

                break;

        }

        if($scope == 'both' || $scope == 'full'){

            Storage::disk($disk)->delete($a->serverfilename);
            $a->serverfilename = $folder . $hashname;
        }

        if($scope == 'both' || $scope == 'tn'){

            Storage::disk($disk)->delete($a->serverfilenametn);
            $a->serverfilenametn = $folder . $tn;

            Storage::disk($disk)->delete($a->serverfilenamesq);
            $a->serverfilenamesq = $folder . $sq;
        }
        
        $a->filename = $filename;
        $a->mimetype = $mime;
        $a->save();

        return $a;

    }

    static public function assetdelete($id)
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $asset = Akiasset::on($db)->find($id);

        if(empty($asset)){

            return false;
        }

        $cat = Akicategory::on($db)->where('slug', $asset->category)->first();

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

        if($asset->serverfilenamesq != ''){

            Storage::disk($disk)->delete($asset->serverfilenamesq);

        }

        $asset->delete();

    }

}
