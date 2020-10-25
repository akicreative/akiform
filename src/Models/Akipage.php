<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;

class Akipage extends Model
{

	protected $connection = '';

	protected $table = 'akiform_pages';

	protected $fillable = ['pagetitle', 'metadescription', 'metakeywords', 'body', 'sitemap', 'sitemappriority', 'url'];

	protected $attributes = ['sitemap' => 0];

	public function __construct(array $attributes = array())
	{

	    parent::__construct($attributes);

	    $this->setConnection(env('AKIPAGE_CONNECTION'));

    }

}
