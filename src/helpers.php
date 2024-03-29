<?php

if (! function_exists('akiu')) {

    function akiu($field = ''){

        $user = session('akiuser', false);

        if($user){

            if(array_key_exists($field, $user)){

                return $user[$field];
            }
        }

        return $user;
    }
}

if (! function_exists('akiavalue')) {

    function akiavalue($array, $key, $default = '') {
        
        if(array_key_exists($key, $array)){

            return $array[$key];

        }else{

            return $default;
        }
    }
}

if (! function_exists('akiformsprovinces')) {

    function akiformsprovinces($abbr = false) {
        
        if($abbr){

            return [
                'AB' => 'AB',
                'BC' => 'BC',
                'MB' => 'MB',
                'NB' => 'NB',
                'NL' => 'NL',
                'NS' => 'NS',
                'NT' => 'NT',
                'NU' => 'NU',
                'ON' => 'ON',
                'PE' => 'PE',
                'QC' => 'QC',
                'SK' => 'SK',
                'YT' =>  'YT'
            ];
        }

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

       if($version == 'clean'){

            if(substr($text, 0, 1) === 1){

                $text = substr($text, 1);
            }

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

        echo '<select class="form-control form-select" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

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

if (! function_exists('hourselect')) {

    function hourselect($name = 'hour', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';
        $start = 0;
        $end = 23;

        extract($params);

        
        for($i = $start; $i <= $end; $i++){

            $values[] = $i;
        }
      
        ob_start();

        echo '<select class="form-control form-select" id="' . $name . '" name="' . $name . '" style="' . $style . '">';

        echo $above;

        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            $output = date("H", strtotime("2000-01-01 " . $value . ':00:00'));
            $display = date("ga", strtotime("2000-01-01 " . $value . ':00:00'));

            echo '<option value="' . $output . '" ' . $selected . '>' . $display . '</option>' . "\n";

        }

        echo '</select>';

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (! function_exists('minuteselect')) {

    function minuteselect($name = 'minute', $default = '', $params = []) {

        $above = '';
        $class = '';
        $style = 'width: auto;';
        $timeminutes = 15;

        extract($params);

        $values[] = 0;

        $minutes = 0;

        switch($timeminutes){
            case 5:
                $values = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55];
                break; 
            case 10:
                $values = [0, 10, 20, 30, 40, 50];
                break;
            case 15:
                $values = [0, 15, 30, 45];
                break;
            case 20:
                $values = [0, 20, 40];
                break;
            case 30:
                $values = [0, 30];
                break;
            default:    

                for($i = 1; $i <= 59; $i++){

                    $values[] = $i;
                }

                break;
        }
      

        ob_start();

        echo '<select class="form-control form-select" id="' . $name . '" name="' . $name . '" style="' . $style . '">';

        echo $above;

        foreach($values as $key => $value){

            $selected = '';

            if($key == $default){

                $selected = 'selected';
            }

            $output = date("i", strtotime("2000-01-01 00:" . $value . ':00'));

            echo '<option value="' . $output . '" ' . $selected . '>' . $output . '</option>' . "\n";

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
            $label = date($datecode, strtotime("2000-" . $i . "-01"));

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
        $size = '';
        $blank = '';

        extract($params);
      
        $values = montharray();

        ob_start();

        echo '<select class="form-control  ' . $size . '" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        if($blank == 'mask'){

            $selected = '';

            if($default == 'MM' || $default == '00' || $default == NULL){

                $selected = 'selected';
            }

            echo '<option value="MM" ' . $selected . '>MM</option>' . "\n";
        }

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
        $size = '';
        $blank = '';

        extract($params);
      
        $values = dayarray();

        ob_start();

        echo '<select class="form-control ' . $size . '" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        if($blank == 'mask'){

            $selected = '';

            if($default == 'DD' || $default == '00' || $default == NULL){

                $selected = 'selected';
            }

            echo '<option value="DD" ' . $selected . '>DD</option>' . "\n";
        }

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

            for($i = $start; $i >= $end; $i--){

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
        $size = '';
        $blank = '';

        extract($params);
      
        $values = yeararray($start, $end);

        ob_start();

        echo '<select class="form-control ' . $size . '" id="' . $name . '" name="' . $name . '" type="select" style="' . $style . '">';

        if($blank == 'mask'){

            $selected = '';

            if($default == 'YYYY' || $default == '00' || $default == NULL){

                $selected = 'selected';
            
            }

            echo '<option value="YYYY" ' . $selected . '>YYYY</option>' . "\n";
        }

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

        $size = '';

        $blank = '';

        extract($params);

        if($size != ''){

            $monthparams['size'] = $size;
            $dayparams['size'] = $size;
            $yearparams['size'] = $size;

        }

        switch($blank){

            case "mask":
            case "words":
            case "blank":
                $monthparams['blank'] = $blank;
                $dayparams['blank'] = $blank;
                $yearparams['blank'] = $blank;
                break;

        }

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

        if(in_array('datepicker', $show)){

            if(request()->input($prefix) == ''){

                return NULL;
            }

            $date = date("Y-m-d", strtotime(request()->input($prefix)));

        }else{


            $month = request()->input($prefix . 'month', '');
            $day = request()->input($prefix . 'day', '');
            $year = request()->input($prefix . 'year', '');

            if(in_array('month', $show)){

                if($month == '' || in_array($month, ['MM', 'Month', '00'])){

                    return NULL;

                }

            }

            if(in_array('day', $show)){

                if($day == '' || in_array($day, ['DD', 'Day', '00'])){

                    return NULL;

                }

            }

            if(in_array('year', $show)){

                if($year == '' || in_array($year, ['YYYY', 'Year', '0000'])){

                    return NULL;

                }

            }

            $date = $year . '-' . $month . '-' . $day;

        }

        if(in_array('hourminute', $show)){

            $hour = request()->input($prefix . 'hour', '00');

            $minute = request()->input($prefix . 'minute', '00');

            $return = date("Y-m-d H:i:00", strtotime($date . ' ' . $hour . ':' . $minute));

        }elseif(in_array('time', $show)){

            $time = request()->input($prefix . 'time', '00:00:00');

            $return = date("Y-m-d H:i:00", strtotime($date . ' ' . $time));

        }else{

            $return = date("Y-m-d", strtotime($date));
        }



        return $return;
    }

}

if (! function_exists('outdate')) {

    function outdate($val, $format = 'M j, Y', $relative = false){

        if($val == NULL || $val == '0000-00-00' || $val == '0000-00-00 00:00:00'){

            return '';
        }else{

            if($format == ''){

                $format = 'M j, Y';
            }

            if($relative){

                $date = date("Y-m-d", strtotime($val));

                $today = date("Y-m-d");

                $yesterday = date("Y-m-d", strtotime("-1 day"));

                $tomorrow = date("Y-m-d", strtotime("+1 day"));

                switch($date){

                    case $today:
                        return 'Today';
                        break;

                    case $tomorrow:
                        return 'Tomorrow';
                        break;

                    case $today:
                        return 'Yesterday';
                        break;

                }

            }

            return date($format, strtotime($val));
        }

    }

}

if(!function_exists('desclist')){

    function desclist($dt, $dd = '', $dtclass = 'col-sm-5 col-md-3', $ddclass = 'col-sm-7 col-md-9', $params = []){

        $cfg = [

            'dlclass' => 'mb-0',
            'complete' => false,
            'dtclass' => 'col-sm-5 col-md-3',
            'ddclass' => 'col-sm-7 col-md-9',
            'divider' => '<hr class="my-1">'

        ];

        if(is_array($dtclass)){

            $params = $dtclass;
        
        }else{

            $cfg['dtclass'] = $dtclass;
            $cfg['ddclass'] = $ddclass;

        }

        foreach($params as $key => $value){

            $cfg[$key] = $value;

        }

        ob_start();



        if($dt == 'open' || $cfg['complete']){

            echo '<dl class="row ' . $cfg['dlclass'] . '">';
        }

        if($dt != 'open' && $dt != 'close'){

            echo '<dt class="' . $cfg['dtclass'] . '">' . $dt . '</dt>';

            echo '<dd class="' . $cfg['ddclass'] . '">' . $dd . '</dd>'; 

            echo $cfg['divider'];

        }

        if($dt == 'close' || $cfg['complete']){

            echo '</dl>';
        }

        $return = ob_get_contents();

        ob_end_clean();

        return $return;


    }

}

if(!function_exists('akidesclist')){

    function akidesclist($dt, $dd = '', $dtclass = 'col-sm-5 col-md-4', $ddclass = 'col-sm-7 col-md-8', $params = []){

        $cfg = [

            'dlclass' => 'mb-0',
            'complete' => false,
            'dtclass' => 'col-sm-5 col-md-4',
            'ddclass' => 'col-sm-7 col-md-8',
            'divider' => '<hr class="my-1">'

        ];

        if(is_array($dtclass)){

            $params = $dtclass;
        
        }else{

            $cfg['dtclass'] = $dtclass;
            $cfg['ddclass'] = $ddclass;

        }

        foreach($params as $key => $value){

            $cfg[$key] = $value;

        }

        if($dt == 'open' || $cfg['complete']){

            echo '<dl class="row ' . $cfg['dlclass'] . '">';
        }

        if($dt != 'open' && $dt != 'close'){

            echo '<dt class="' . $cfg['dtclass'] . '">' . $dt . '</dt>';

            echo '<dd class="' . $cfg['ddclass'] . '">' . $dd . '</dd>'; 

        }

        if($dt == 'close' || $cfg['complete']){

            echo '</dl>';
        }

        return;


    }

}


if (! function_exists('akiredactor')) {

    function akiredactor($mode = '', $params = []) {
        
        if($mode == 'css'){

            echo '<link rel="stylesheet" href="' . url('/vendor/akicreative/akiforms/redactor/redactor.min.css') . '">';

        }elseif($mode == 'js'){

            echo '
                <script src="' . url('/vendor/akicreative/akiforms/redactor/redactor.min.js') . '"></script>
                <script src="' . url('/vendor/akicreative/akiforms/redactor/plugins/alignment/alignment.min.js') . '"></script>
                <script src="' . url('/vendor/akicreative/akiforms/redactor/plugins/fontsize/fontsize.min.js') . '"></script>
                <script src="' . url('/vendor/akicreative/akiforms/redactor/plugins/fontcolor/fontcolor.min.js') . '"></script>
                <script src="' . url('/vendor/akicreative/akiforms/redactor/plugins/inlinestyle/inlinestyle.js') . '"></script>
                <script src="' . url('/vendor/akicreative/akiforms/redactor/plugins/table/table.js') . '"></script>
            ';

        }else{

            $plugins = ['alignment', 'inlinestyle', 'fontsize', 'fontcolor', 'table'];
            $buttons = ['format', 'bold', 'italic', 'deleted', 'lists', 'link'];
            $fileupload = '';
            $imageupload = '';
            $allplugins = false;
            $pluginadd = [];
            $pluginremove = [];
            $buttonadd = [];
            $buttonremove = [];

            extract($params);

            for($i = 0; $i < count($pluginremove); $i++){

                $val = $pluginadd[$i];

                unset($plugins[$val]);
            }

            for($i = 0; $i < count($pluginadd); $i++){

                $val = $pluginadd[$i];

                $plugins[] = $val;
            }  

            for($i = 0; $i < count($buttonremove); $i++){

                $val = $buttonadd[$i];

                unset($buttons[$val]);
            }

            for($i = 0; $i < count($buttonadd); $i++){

                $val = $buttonadd[$i];

                $buttons[] = $val;
            }            

            $vars = ["linkNewTab: true"];

            if(count($plugins) > 0){

                $vars[] = "plugins: ['" . implode("', '", $plugins) . "']";
            } 

            $vars[] = "buttons: ['" . implode("', '", $buttons) . "']";

            echo '<script type="text/javascript">

           

            ';

            echo '$("' . $mode . '").redactor({';

                if(count($vars) > 0){

                    echo implode(", ", $vars);

                }

          

            echo '

                });

                </script>

            ';


        }
        
    }

}

if (! function_exists('akitextblock')) {

    function akitextblock($id, $textonly = false)
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $block = AkiCreative\AkiForms\Models\Akitextblock::on($db)->find($id);

        if(empty($block)){

            return false;
        }

        if($textonly){

            return $block->textblock;

        }else{

            $return = [

                'heading' => $block->heading,
                'textblock' => $block->textblock,
                'format' => $block->format,
                'obj' => $block

            ];

            return $return;

        }

    }

}

if (! function_exists('akitextblocks')) {

    function akitextblocks($category = '')
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $items = AkiCreative\AkiForms\Models\Akitextblock::on($db)->where('category', $category);

        return $items;

    }

}

if (! function_exists('akipage')) {

    function akipage($id)
    {

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $page = AkiCreative\AkiForms\Models\Akipage::on($db)->find($id);

        if(empty($page)){

            return false;
        }

        return $page;

    }

}

if (! function_exists('akiassetitems')) {

    function akiassetitems($category, $referenceid = 0, $subcategory = NULL)
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $return = \AkiCreative\AkiForms\Models\Akiasset::on($db)->where('category', $category);

        if($referenceid > 0){

            $return = $return->where('referenceid', $referenceid);

        }elseif($referenceid == 'zero'){

            $return = $return->where('referenceid', 0);
        }

        if($subcategory != NULL){

            $return = $return->where('subcategory', $subcategory);

        }

        $return = $return->orderBy('orderby', 'ASC');

        return $return;

    }

}

if (! function_exists('akiassetrandom')) {

    function akiassetrandom($category, $count = 1, $subcategory = NULL)
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $return = \AkiCreative\AkiForms\Models\Akiasset::on($db)->where('category', $category);

        if($subcategory != NULL){

            $return = $return->where('subcategory', $subcategory);

        }

        if($count > 1){

            $return = $return->inRandomOrder();

        }else{

            $return = $return->inRandomOrder()->first();

        }

        return $return;

    }

}

if (! function_exists('akiasset')) {

    function akiasset($id, $size = 'full', $obj = false)
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $asset = \AkiCreative\AkiForms\Models\Akiasset::on($db)->find($id);

        if(empty($asset)){

            return false;
        }

        if($obj){

            return $asset;

        }else{

            if($size == 'full'){

                return asset('storage/' . $asset->serverfilename);

            }elseif($size == 'sq'){

                return asset('storage/' . $asset->serverfilenamesq);

            }else{


                return asset('storage/' . $asset->serverfilenametn);
            }

        }

    }

}

if (! function_exists('akiassetsubcategories')) {

    function akiassetsubcategories($category) {

        $return = [];

        $db = config('akiforms.connection.akiasset', config('database.default'));
        
        $subs = \AkiCreative\AkiForms\Models\Akisubcategory::on($db)->where('category', $category)->where("active", 1)->orderBy('name')->get();

        foreach($subs as $sub){

            $key = $sub->slug;

            $return[$key] = $sub->name;
        }

        return $return;

    }

}

if (! function_exists('akiassetcreatesubcategory')) {

    function akiassetcreatesubcategory($category, $name = '') {

        if($name == '') return;

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $slug = $category . '-' . \Illuminate\Support\Str::of($name)->slug('');

        $subcat = \AkiCreative\AkiForms\Models\Akisubcategory::on($db)->where('category', $category)->where('slug', $slug)->first();

        if(empty($subcat)){

            $subcat = new \AkiCreative\AkiForms\Models\Akisubcategory;
            $subcat->setConnection($db);
            $subcat->slug = $slug;
            $subcat->category = $category;
            $subcat->name = $name;
            $subcat->save();

        }

        return $subcat->slug;

    }

}

if (! function_exists('akiassetadd')) {

    function akiassetadd($category, $file, $deleteid = 0, $cfg = []) {
        
        return \AkiCreative\AkiForms\Models\Akiasset::assetadd($category, $file, $deleteid, $cfg);

    }

}

if (! function_exists('akiassetreplace')) {

    function akiassetreplace($id, $file, $scope = 'both') {
        
        return \AkiCreative\AkiForms\Models\Akiasset::assetreplace($id, $file, $scope);

    }

}

if (! function_exists('akiassetdelete')) {

    function akiassetdelete($id) {
        
        \AkiCreative\AkiForms\Models\Akiasset::assetdelete($id);

    }

}




if (! function_exists('akiasseturl')) {

    function akiasseturl($id, $mode = 'full', $auth = false)
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $a = \AkiCreative\AkiForms\Models\Akiasset::on($db)->where('id', $id)->first();

        if(empty($a)){

            return '#';
        }

        $c = \AkiCreative\AkiForms\Models\Akicategory::on($db)->where('slug', $a->category)->first();

        $scope = 'public';

        $target = env('AKIASSETPUBLIC', 'local');

        if($c->private){

            $scope = 'private';

            $target = env('AKIASSETPRIVATE', 'local');
        }

        if($scope == 'private' && !$auth){

            return '#';
        }

        if($target != 'local'){

            if($a->type() == "image" || $a->type() == "gif"){

                if($mode == 'full' || $a->type() == "gif"){

                    if($scope == 'public'){

                        return Storage::disk($target)->url($a->serverfilename);

                    }else{

                        return Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(5));
                    }

                }elseif($mode == 'sq' && $a->serverfilenamesq != ''){

                    if($scope == 'public'){

                        return Storage::disk($target)->url($a->serverfilenamesq);

                    }else{

                        return Storage::disk($target)->temporaryUrl($a->serverfilenamesq, now()->addMinutes(5));
                    }

                }else{

                    if($scope == 'public'){

                        return Storage::disk($target)->url($a->serverfilenametn);

                    }else{

                        return Storage::disk($target)->temporaryUrl($a->serverfilenametn, now()->addMinutes(5));
                    }
                }

            }else{

                $fn = preg_replace("!\/!", ":", $a->serverfilename);

                if($scope == 'public'){

                    return Storage::disk($target)->url($a->serverfilename);

                }else{

                    return Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(5));
                }

                /*

                return route('aki.asset.aws', [$a->id, $fn]);

                */

            }


        }else{

            if($mode == 'full' || $a->type() != 'image'){

                $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilename);

                return route('aki.asset.' . $scope, [$id, $fn]);
            
            }else{

                $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilenametn);

                return route('aki.asset.' . $scope, [$id, $fn]);

            }

        }
        
    }

}

if (! function_exists('akiasseturls')) {

    function akiasseturls($id, $auth = false)
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $a = \AkiCreative\AkiForms\Models\Akiasset::on($db)->where('id', $id)->first();

        $return = [

            'full' => '#',
            'thumb' => '#',
            'square' => '#'

        ];

        if(empty($a)){

            return false;
        }

        $c = \AkiCreative\AkiForms\Models\Akicategory::on($db)->where('slug', $a->category)->first();

        $scope = 'public';

        $target = env('AKIASSETPUBLIC', 'local');

        if($c->private){

            $scope = 'private';

            $target = env('AKIASSETPRIVATE', 'local');
        }

        if($scope == 'private' && !$auth){

            return false;
        }

        if($target != 'local'){

            if($a->type() == "image" || $a->type() == "gif"){


                if($scope == 'public'){

                    $return['full'] = Storage::disk($target)->url($a->serverfilename);
                    $return['thumb'] = $return['full'];
                    $return['square'] = $return['square'];

                }else{

                    $return['full'] = Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(5));
                    $return['thumb'] = $return['full'];
                    $return['square'] = $return['full'];
                }

                if($a->type() == "gif"){

                    return $return;

                }

                if($a->serverfilenamesq != ''){

                    if($scope == 'public'){

                        $return['square'] = Storage::disk($target)->url($a->serverfilenamesq);

                    }else{

                        $return['square'] = Storage::disk($target)->temporaryUrl($a->serverfilenamesq, now()->addMinutes(5));
                    }

                }else{

                    if($scope == 'public'){

                        $return['thumb'] = Storage::disk($target)->url($a->serverfilenametn);

                    }else{

                        $return['thumb'] = Storage::disk($target)->temporaryUrl($a->serverfilenametn, now()->addMinutes(5));
                    }
                }

            }else{

                $fn = preg_replace("!\/!", ":", $a->serverfilename);

                if($scope == 'public'){

                    $return['full'] = Storage::disk($target)->url($a->serverfilename);
                    $return['thumb'] = $return['full'];
                    $return['square'] = $return['full'];

                }else{

                    $return['full'] = Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(5));
                    $return['thumb'] = $return['full'];
                    $return['square'] = $return['full'];
                }



                /*

                return route('aki.asset.aws', [$a->id, $fn]);

                */

            }

            return $return;


        }else{

            if($mode == 'full' || $a->type() != 'image'){

                $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilename);

                return route('aki.asset.' . $scope, [$id, $fn]);
            
            }else{

                $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilenametn);

                return route('aki.asset.' . $scope, [$id, $fn]);

            }

        }
        
    }

}

if (! function_exists('akiassetpicture')) {

    function akiassetpicture($id, $auth = false, $cfgin = [])
    {

        $db = config('akiforms.connection.akiasset', config('database.default'));

        $cfg = [

            'class' => ''

        ];

        foreach($cfgin as $key => $value){

            $cfg[$key] = $value;
        }

        $a = \AkiCreative\AkiForms\Models\Akiasset::on($db)->where('id', $id)->first();

        if(empty($a)){

            return '';
        }

        $c = \AkiCreative\AkiForms\Models\Akicategory::on($db)->where('slug', $a->category)->first();

        $scope = 'public';

        $target = env('AKIASSETPUBLIC', 'local');

        if($c->private){

            $scope = 'private';

            $target = env('AKIASSETPRIVATE', 'local');
        }

        if($scope == 'private' && !$auth){

            return '';

        }

        if($a->type() == "image"){

            if($scope == 'public'){

                $full = Storage::disk($target)->url($a->serverfilename);

            }else{

                $full = Storage::disk($target)->temporaryUrl($a->serverfilename, now()->addMinutes(5));
            }

            if($scope == 'public'){

                $thumb = Storage::disk($target)->url($a->serverfilenametn);

            }else{

                $thumb = Storage::disk($target)->temporaryUrl($a->serverfilenametn, now()->addMinutes(5));
            }

            ob_start();

            echo '<picture>';
            echo '<source media="(min-width: 650px)" srcset="' . $full . '">';
            echo '<source media="(min-width: 465px)" srcset="' . $thumb . '">';
            echo '<img src="' . $full . '" class="img-fluid ' . $cfg['class'] . '" alt="' . $a->name . '">';
            echo '</picture>';

            $output = ob_get_contents();

            ob_end_clean();

            return $output;

        }else{

            return '';

        }

    }
        

}

if (! function_exists('akitelegramsend')) {

    function akitelegramsend($chatid, $message, $params = []) {
        // ...

        $silent = true;

        $botToken = env('TELEGRAMBOT', '');

        if($botToken == ''){

            return;
        }

        $chat_id = $chatid;
        $bot_url    = "https://api.telegram.org/bot$botToken/";
        $url = $bot_url . "sendMessage";

        extract($params);

        $postfields = array(

            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => true,
            'disable_notification' => $silent

        );

        $curld = curl_init();

        curl_setopt($curld, CURLOPT_POST, true);
        curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($curld, CURLOPT_URL,$url);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($curld);

        curl_close ($curld);

        return json_decode($output, true);

    }

}

if (! function_exists('akisetjsonfield')) {

    function akisetjsonfield($field)
    {
   
        $prefix = $field . '-';

        $a = [];

        foreach(request()->all() as $key => $value){

            if(preg_match("!^" . $prefix . "!", $key)){

                $array = explode("-", $key);

                $newkey = $array[1];

                $a[$newkey] = $value;

            }
        }

        return $a;

    }

}

if (! function_exists('akimoney')) {

    function akimoney($amount, $integer = false)
    {

        if($amount == NULL){

            $amount = 0;
        }

        if(!$integer && $amount > 0){

            $amount  = ($amount * 100) / 100;
        }

        $fmt = new \NumberFormatter( 'en_CA', \NumberFormatter::CURRENCY );
        $fmt->setAttribute($fmt::FRACTION_DIGITS, 2);

        return $fmt->formatCurrency($amount, "CAD");

    }

}

if (! function_exists('akidollar')) {

    function akidollar($amount, $comma = '')
    {

        return number_format($amount, 2, ".", $comma);

    }

}

if (! function_exists('akidl')) {

    function akidl($dd, $dt = '', $cfg = []){

        if($dd == 'akidlopen'){

            echo '<dl class="row mb-0">';
            return;
        }

        if($dd == 'akidlclose'){

            echo '</dl>';
            return;
        }

        $complete = false;
        $divider = true;
        $dtclass = 'col-sm-5';
        $ddclass = 'col-sm-7';
        $hideblank = true;

        extract($cfg);
        
        if($dt == '' && $hideblank){


        }else{

            if($complete){

                echo '<dl class="row mb-0">';
            }

            echo '

            <dt class="' . $dtclass . '">' . $dd . '</dt>
            <dd class="' . $ddclass . '">' . $dt . '</dd>

            ';

            if($complete){

                echo '</dl>';

                if($divider){

                    echo '<hr class="mt-0 mb-1">';
                }
            }

            
        }

    }

}

if(! function_exists('akiemailbutton')){


    function akiemailbutton($style = 'primary')
    {

        $output = '';

        switch($style){

            default:
                $output .= 'color: #fff; background-color: #007bff; border-color: #007bff;';
                break;
        }

        $output .= 'display: inline-block;
                font-weight: 400;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                border: 1px solid transparent;
                padding: .375rem .75rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: .25rem;
                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                text-decoration: none;';

        return $output;

    }

}

if(! function_exists('akicountry')){


    function akicountry($abbr = '')
    {

        $array = [
            "CA" => "Canada",
            "US" => "United States",
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua And Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia And Herzegowina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, The Democratic Republic Of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia (Local Name: Hrvatska)",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "TP" => "East Timor",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "FX" => "France, Metropolitan",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GB" => "United Kingdom",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard And Mc Donald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran (Islamic Republic Of)",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic Of",
            "KR" => "Korea, Republic Of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau",
            "MK" => "Macedonia, Former Yugoslav Republic Of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States Of",
            "MD" => "Moldova, Republic Of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "KN" => "Saint Kitts And Nevis",
            "LC" => "Saint Lucia",
            "VC" => "Saint Vincent And The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome And Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia (Slovak Republic)",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia, South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SH" => "St. Helena",
            "PM" => "St. Pierre And Miquelon",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard And Jan Mayen Islands",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic Of",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad And Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks And Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands (British)",
            "VI" => "Virgin Islands (U.S.)",
            "WF" => "Wallis And Futuna Islands",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "YU" => "Yugoslavia",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ];

        if($abbr == ''){

            return $array;
        }

        if(array_key_exists($abbr, $array)){

            return $array["$abbr"];
        
        }else{

            return '';

        }

    }

}

if (! function_exists('akitoast')) {

    function akitoast($placement = 'bottom')
    {

        $route = route('aki.toast');

        if($placement == 'top'){
echo <<<EOT
<div id="toastcontainer" style="position: fixed; top: 10px; right: 10px; z-index: 5000;">
</div>
EOT;
        }elseif($placement == 'middle'){

echo <<<EOT
<div id="toastcontainer" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="height: 200px; z-index: 5000;">
EOT;


        }else{

echo <<<EOT
<div id="toastcontainer" style="position: fixed; bottom: 10px; right: 10px; z-index: 5000;">
</div>
EOT;

        }



echo <<<EOT
<script type="text/javascript">

function addToast(header, body, headerclass = '', delay = 5000){

    $.post('{$route}', { header: header, body: body, headerclass: headerclass, delay: delay }, function(result) {

        $('#toastcontainer').append(result);

    });

}

</script>
EOT;

    }

}

if (! function_exists('akitoastie')) {

    function akitoastie($placement = 'bottom')
    {

        $route = route('aki.toast');

        if($placement == 'top'){
echo <<<EOT
<div id="toastcontainer" style="position: fixed; top: 10px; right: 10px; z-index: 5000;">
</div>
EOT;
        }elseif($placement == 'middle'){

echo <<<EOT
<div id="toastcontainer" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="height: 200px; z-index: 5000;">
EOT;


        }else{

echo <<<EOT
<div id="toastcontainer" style="position: fixed; bottom: 10px; right: 10px; z-index: 5000;">
</div>
EOT;

        }



echo <<<EOT
<script type="text/javascript">

function addToast(header, body, headerclass, delay){

    if(typeof headerclass === 'undefined'){

        headerclass = '';
    }

    if(typeof delay === 'undefined'){

        delay = 5000;
    }

    $.post('{$route}', { header: header, body: body, headerclass: headerclass, delay: delay }, function(result) {

        $('#toastcontainer').append(result);

    });

}

</script>
EOT;

    }

}

if(!function_exists('akiphpvalidation')) {

    function akiphpvalidation($url = '')
    {

        if($url == ''){

            $url = action('ValidateController@phpvalidate');

        }

echo <<<EOT
<script type="text/javascript">

(function(){
    
    $(window).keydown(function(event){

        if(!$("textarea").is(":focus")){

            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }

        }
    });

    $('.phpvalidationbutton').on('click', function(el){
        
        var formid = $(this).data('form');

        var form = $(formid);

        var formData = new FormData(form[0]);

        $('#buttonaction').val($(this).val());

        $.ajax({

            url: '{$url}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(validation){

                $('#toastcontainer').html('');

                console.log(validation);

                returnresult = validation.result;

                console.log(validation.result);

                for (i = 0; i < validation.toasts.length; i++) { 
                  
                    addToast(validation.toasts[i].header, validation.toasts[i].body, 'bg-primary text-white', 10000);
                
                }

                if(returnresult == 'FAILED'){

                    validationpassed = 'N';

                }else{

                    validationpassed = 'Y';

                    form.submit();

                }

               

            }

        });       

    });

})();

</script>
EOT;

    }

}

if (! function_exists('manageprefs')) {

    function manageprefs($action, $array, $value){

        if(!is_array($array)){

            $array = [];
        }

        if($action == 'toggle'){

            if(in_array($value, $array)){

                $action = 'remove';

            }else{

                $action = 'add';
            }

        }

        if($action == 'add'){

            if(!in_array($value, $array)){

                $array[] =  $value;
            
            }

            return $array;

        }elseif($action == 'remove'){

            $newarray = [];

            foreach($array as $a){

                if($a != $value){

                    $newarray[] = $a;
                }

            }

            return $newarray;

        }

        return $array;

    }
}

if (! function_exists('swapprefs')) {

    function swapprefs($array, $add, $keys){

        if(!is_array($array)){

            $array = [];
        }

        foreach($keys as $key){

            if($add == $key){

                $array = manageprefs('add', $array, $key);

            }else{

                $array = manageprefs('remove', $array, $key);

            }

        }

        return $array;

    }
}

if (! function_exists('checkprefs')) {

    function checkprefs($array, $key){

        if(!is_array($array)){

            $array = [];
        }

        if(!is_array($key)){

            $keyarray = [$key];
        }else{

            $keyarray = $key;
        }

        foreach($keyarray as $k){

            if(in_array($k, $array)){

                return $k;
            
            }

        }

        return false;

    }
}
