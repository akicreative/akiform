<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akitextblock extends Model
{

	protected $connection = '';

	protected $table = 'akiform_textblocks';

	protected $fillable = ['category', 'name', 'heading', 'textblock', 'format', 'orderby'];

	protected $attributes = ['headerasset_id' => 0];

	public function __construct(array $attributes = array())
	{

	    parent::__construct($attributes);

	    $this->setConnection(env('AKITEXTBLOCK_CONNECTION'));

	}

}
