<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DatepickerController extends Controller
{

	public function __construct()
	{


	}

	public function index(){

		echo "<pre>";
		print_r(time());
		echo "</pre>";	
	}

	public function calendar(Request $request)
	{

		echo "<pre>";
		print_r($request->all());
		echo "</pre>";	

        $current = strtotime(request()->input('current', date("Y-m-d")));
        
        $currentday = date("d", $current);
        $currentmonth = date("m", $current);
        $currentyear = date("Y", $current);

        $yearstart = date("Y");
        $yearend = date("Y") + 5;

        $prevmonth = date("m", mktime(0, 0, 0, $currentmonth - 1, 1, $currentyear));
        $prevyear = date("Y", mktime(0, 0, 0, $currentmonth - 1, 1, $currentyear));
        $nextmonth = date("m", mktime(0, 0, 0, $currentmonth + 1, 1, $currentyear));
        $nextyear = date("Y", mktime(0, 0, 0, $currentmonth + 1, 1, $currentyear));

        $currentfirstdayofweek = date("w", strtotime($currentyear . '-' . $currentmonth . '-01'));
        $currentlastdayofmonth = date("t", strtotime($currentyear . '-' . $currentmonth . '-01'));

        $startrange = request()->input('startrange', '');

        if($startrange != ''){

            $startrange  = strtotime($startrange);
        }

        $endrange = request()->input('endrange', '');

        if($endrange != ''){

            $endrange  = strtotime($endrange);
        }   

        $exclude = request()->input('exclude');

        $excludedays = explode(":", $exclude);

        $data = [

        	'current' => $currentday,
        	'currentmonth' => $currentmonth,
        	'currentyear' => $currentyear,
        	'yearstart' => $yearstart,
        	'yearend' => $yearend,
        	'prevmonth' => $prevmonth,
        	'prevyear' => $prevyear,
        	'nextmonth' => $nextmonth,
        	'nextyear' => $nextyear,
        	'currentfirstdayofweek' => $currentfirstdayofweek,
        	'currentlastdayofmonth' => $currentlastdayofmonth,
        	'startrange' => $startrange,
        	'endrange' => $endrange,
        	'exclude' => $exclude,
        	'excludedays' => $excludedays

        ];

        // weekdays, weekends, 0 - 6, dates

        return view('akiforms::datepicker.calendar', $data);


	}

}