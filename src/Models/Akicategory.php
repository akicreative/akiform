<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akicategory extends Model
{

	protected $table = 'akiform_categories';

    public static function selectoptions($cattype, $hide = true)
    {

        if($hide){

            $hidden = [0];

        }else{

            $hidden = [0, 1];
        }

        $cats = Akicategory::where('cattype', $cattype)->whereIn('hidden', $hidden)->get();

        $return = [];

        foreach($cats as $cat){

            $key = $cat->slug;

            $return[$key] = $cat->name;
        }

        return $return;

    }

}
