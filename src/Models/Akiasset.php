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


    public function picture($srcinput = [])
    {

        $asset = $this;

        $src = [

            'sm' => '',
            'md' => '',
            'lg' => ''
        ];

        foreach($srcinput as $key => $value){

            $src[$key] = $value;
        }


        ob_start();

        echo '<picture>';
        echo '<source media="(min-width: 650px)" srcset="' . asset('storage/' . $asset->serverfilename) . '" ' . $md . '>';
        echo '<source media="(min-width: 465px)" srcset="' . asset('storage/' . $asset->serverfilenametn) . '" ' . $sm . '>';
        echo '<img src="' . asset('storage/' . $asset->serverfilename) . '" class="img-fluid" alt="' . $asset->name . '"' . $lg . '>';


        echo '</picture>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;

    }

}
