<?php

if (! function_exists('akiformsprovinces')) {

    function akiformsprovinces() {
        
        return [
			'AB' => 'Alberta',
			'BC' => 'British Columbia',
			'MB' => 'Manitoba',
			'NB' => 'New Brunswick',
			'NL' => 'Newfoundland and Labrador',
			'NS' => 'Nova Scotia',
			'NT' => 'Northwest Territories',
			'NU' => 'Nunavut',
			'ON' => 'Ontario',
			'PE' => 'Prince Edward Island',
			'QC' => 'Quebec',
			'SK' => 'Saskatchewan',
			'YT' =>  'Yukon'
		];
    }
}

if (! function_exists('akiformsstates')) {

    function akiformsstates() {
        
        return [

			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DC' => 'District Of Columbia',
			'DE' => 'Delaware',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'NE' => 'Nebraska',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NV' => 'Nevada',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'PR' => 'Puerto Rico',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VA' => 'Virginia',
			'VI' => 'Virgin Islands',
			'VT' => 'Vermont',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming'
		];
    }
}

if (! function_exists('formatphone')) {

    function formatphone($text, $version = 'dash') {
        // ...

       $text = preg_replace("![^0-9]+!", "", $text);

       if($text == ''){
       		return $text;
       }

       $text = preg_replace("!^1!", "", $text);

       $num1 = substr($text, 0, 3);
    
       $num2 = substr($text, 3, 3);

       $num3 = substr($text, 6, 4);

       $ext = substr($text, 10);

       if($version == 'dash'){

       		$return = $num1 . '-' . $num2 . '-' . $num3;

       		if($ext != ''){

       			$return = $return . ' ext ' . $ext;
       		}
       }else{

       		$return = '(' .$num1 . ') ' . $num2 . '-' . $num3;

       		if($ext != ''){

       			$return = $return . ' ext ' . $ext;
       		}
       }

       return $return;

    }
}

if (! function_exists('timearray')) {

    function timearray($minutes = 15) {
      
        $return = [];

        for($i = 0; $i <= 23; $i++){

            switch($minutes){

                case "15":
                    $minutes = ["00", 15, 30, 45];
                    break;
                case "30":
                    $minutes = ["00", 30];
                    break;
            }

            foreach($minutes as $m){

                $label = date("g:ia", strtotime("$i:$m"));

                $key = date("H:i:00", strtotime("$i:$m"));

                $return[$key] = $label;

            }

        }

        return $return;
    }
}

if (! function_exists('timeselect')) {

    function timeselect($name = 'time', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';
        $timeminutes = 15;

        extract($params);
      
        $values = timearray($timeminutes);

        $hour = date("H", strtotime($default));

        $minute = date("i", strtotime($default));

        $time = $hour . ":";

        if($minute == 0){

        	$time = $time . "00";

        }elseif($minute <= 15 && $minute > 0){

            if($timeminutes == 15){

                $time = $time . 15;

            }else{

                $time = $time . 30;
            }
        
        }elseif($minute <= 30 && $minute > 0){

            $time = $time . 30;

        }elseif($minute <= 45 && $minute > 0){

            if($timeminutes == 15){

                $time = $time . 45;

            }else{

                $time = $hour + 1 . ":00";
            }

        }else{

            $time = $hour + 1 . ":00";
        }

        $default = date("H:i:00", strtotime($time));

        ob_start();

        echo '<select class="form-control" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        echo $above;



        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>' . "\n";

        }

        echo '</select>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (! function_exists('monthselect')) {

    function monthselect($name = 'month', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';

        extract($params);
      
        $values = montharray();

        ob_start();

        echo '<select class="form-control" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        echo $above;

        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>' . "\n";

        }

        echo '</select>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (! function_exists('montharray')) {

    function montharray($datecode = "F") {
      
        $return = [];

        for($i = 1; $i <= 12; $i++){

            $key = date("m", strtotime("2000-" . $i . "-01"));
            $label = date("F", strtotime("2000-" . $i . "-01"));

            $return[$key] = $label;

        }

        return $return;
    }
}

if (! function_exists('monthselect')) {

    function monthselect($name = 'month', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';

        extract($params);
      
        $values = montharray();

        ob_start();

        echo '<select class="form-control" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        echo $above;

        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>' . "\n";

        }

        echo '</select>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (! function_exists('dayarray')) {

    function dayarray() {
      
        $return = [];

        for($i = 1; $i <= 31; $i++){

            $key = date("d", strtotime("2000-01-" . $i));
            $label = date("j", strtotime("2000-01-" . $i));

            $return[$key] = $label;

        }

        return $return;
    }
}

if (! function_exists('dayselect')) {

    function dayselect($name = 'day', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';

        extract($params);
      
        $values = dayarray();

        ob_start();

        echo '<select class="form-control" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        echo $above;

        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>' . "\n";

        }

        echo '</select>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (! function_exists('yeararray')) {

    function yeararray($start = '', $end = '') {
      
        if($start == ''){

            $start = date("Y");
        }

        if($end == ''){

            $end = date("Y") + 5;
        }     

        $return = [];

        if($end >= $start){

            for($i = $start; $i <= $end; $i++){

                $key = $i;

                $return[$i] = $i;

            }

        }else{

            for($i = $end; $i >= $start; $i--){

                $key = $i;

                $return[$i] = $i;

            }
        }

        return $return;
    }
}

if (! function_exists('yearselect')) {

    function yearselect($name = 'year', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';
        $start = '';
        $end = '';

        extract($params);
      
        $values = yeararray($start, $end);

        ob_start();

        echo '<select class="form-control" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        echo $above;

        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>' . "\n";

        }

        echo '</select>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (! function_exists('dateselect')) {

    function dateselect($prefix, $params = []) {

        $show = ['month', 'day', 'year'];

        $monthparams = [];
        $dayparams = [];
        $yearparams = [];

        $timeminutes = 15;
        $timename = 'time';

        $default = date("Y-m-d H:i:00");

        $month = '';
        $day = '';
        $year = '';

        $label = '';

        extract($params);

        if($default != ''){

            $month = date("m", strtotime($default));
            $day = date("d", strtotime($default));
            $year = date("Y", strtotime($default));
        }

        ob_start();

        if($label != ''){

            echo '<div class="form-group">';
            echo '<label>' . $label . '</label>';

        }

        echo '<ul class="list-inline mb-0">';

        if(in_array('month', $show)){

            echo '<li class="list-inline-item">';

            echo monthselect($prefix . 'month', $month, $monthparams);

            echo '</li>';

        }

        if(in_array('day', $show)){

            echo '<li class="list-inline-item">';

            echo dayselect($prefix . 'day', $day, $dayparams);

            echo '</li>';

        }

        if(in_array('year', $show)){

            echo '<li class="list-inline-item">';

            echo yearselect($prefix . 'year', $year, $yearparams);

            echo '</li>';

        }

        if(in_array('time', $show)){

            echo '<li class="list-inline-item">';

            echo timeselect($prefix . 'time', $default, ['minutes' => $timeminutes]);

            echo '</li>';
        }


        echo '</ul>';

        if($label != ''){

            echo '</div>';

        }

        $return = ob_get_contents();

        ob_get_clean();

        return $return;

    }

}

if (! function_exists('datesql')) {

    function datesql($prefix, $params = []) {

        $show = ['month', 'day', 'year'];

        extract($params);

        $month = request()->input($prefix . 'month', '');
        $day = request()->input($prefix . 'day', '');
        $year = request()->input($prefix . 'year', '');

        if(in_array('time', $show)){

            $time = request()->input($prefix . 'time', '00:00:00');

            $return = date("Y-m-d H:i:00", strtotime($year . '-' . $month . '-' . $day . ' ' . $time));

        }else{

            $return = date("Y-m-d", strtotime($year . '-' . $month . '-' . $day));
        }

        return $return;
    }

}