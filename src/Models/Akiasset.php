<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

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

}
