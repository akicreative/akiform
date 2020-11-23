<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akiinfolist extends Model
{

	protected $table = 'akiform_infolists';

    use HasFactory;

    protected $attributes = [

    	'active' => 0

    ];
}
