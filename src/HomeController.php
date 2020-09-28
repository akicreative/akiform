<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

	public function toast(Request $r){

		$data['toastheader'] = $r->input('header', 'SAVED!');
        $data['toastbody'] = $r->input('body', 'The item has been saved.');
        $data['toastheaderclass'] = $r->input('headerclass', '');
        $data['toastdelay'] = $r->input('delay', 5000);

        return view('akiforms::partials.toast', $data)->render();
	}

}