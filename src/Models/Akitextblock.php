<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akitextblock extends Model
{

	protected $table = 'akiform_textblocks';

	protected $fillable = ['category', 'name', 'heading', 'textblock', 'format', 'orderby'];

	protected $attributes = ['headerasset_id' => 0];

	protected $casts = ['more' => 'json'];

}
