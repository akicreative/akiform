<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akicategory extends Model
{

	protected $table = 'akiform_categories';

    public static function selectoptions($cattype, $hide = true, $private = 'NA')
    {

        // Private = Y, N, A

        if($hide){

            $hidden = [0];

        }else{

            $hidden = [0, 1];
        }

        $cats = Akicategory::where('cattype', $cattype)->whereIn('hidden', $hidden);

        switch($private){

            case "1":
                $cats = $cats->where('private', 1);
                break;
            case "0":
                $cats = $cats->where('private', 0);
                break;

        }

        $cats = $cats->orderBy('private', 'ASC')->orderBy('name', 'ASC')->setConnection(config('akiforms.connection.akiasset', config('database.default')))->get();

        $return = [];

        foreach($cats as $cat){

            $key = $cat->slug;

            if($cat->private){

                $return[$key] = $cat->name . ' [PRIVATE]';
                
            }else{

                $return[$key] = $cat->name;
        
            }

        }

        return $return;

    }

}
