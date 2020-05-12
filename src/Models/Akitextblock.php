<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akitextblock extends Model
{

	protected $table = 'akiform_textblocks';

	protected $fillable = ['category', 'name', 'heading', 'textblock', 'format', 'orderby'];

}
