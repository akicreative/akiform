<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akicategory extends Model
{

	protected $table = 'akiform_categories';

    public static function selectoptions($cattype)
    {

        $cats = Akicategory::where('cattype', $cattype)->get();

        $return = [];

        foreach($cats as $cat){

            $key = $cat->slug;

            $return[$key] = $cat->name;
        }

        return $return;

    }

}
