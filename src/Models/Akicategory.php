<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akicategory extends Model
{

	protected $table = 'akiform_categories';

    const CATTYPE = [

        'asset' => 'Images / Files',
        'textblock' => 'Blocks of Text'

    ];

    protected $fillable = [

        'slug', 'cattype', 'name', 'description', 'hidden', 'private', 'assetw', 'asseth', 'assettnresize', 'assettnw', 'assettnh', 'assetsqw', 'assetsqh','cfgs'

    ];

    protected $casts = [

        'cfgs' => 'json'

    ];

    public static function selectoptions($cattype, $hide = true, $private = 'NA')
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        // Private = Y, N, A

        if($hide){

            $hidden = [0];

        }else{

            $hidden = [0, 1];
        }

        $cats = Akicategory::on($db)->where('cattype', $cattype)->whereIn('hidden', $hidden);

        switch($private){

            case "1":
                $cats = $cats->where('private', 1);
                break;
            case "0":
                $cats = $cats->where('private', 0);
                break;

        }

        $cats = $cats->orderBy('private', 'ASC')->orderBy('name', 'ASC')->get();

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
