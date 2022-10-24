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

    const TYPES = [

        'textlink' => 'Link',
        'textfile' => 'File',
        'htmltext' => 'HTML Text',
        'plaintext' => 'Plain Text',
        'header' => 'Header'

    ];

    protected $fillable = [

        'active', 'category', 'infotype', 'title', 'html', 'description', 'url', 'newwindow', 'spaceafter', 'dividerafter', 'orderby'

    ];
}
