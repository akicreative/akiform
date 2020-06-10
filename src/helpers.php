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

       if($version == 'clean'){

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

        if(in_array('time', $show)){

            $time = request()->input($prefix . 'time', '00:00:00');

            $return = date("Y-m-d H:i:00", strtotime($year . '-' . $month . '-' . $day . ' ' . $time));

        }else{

            $return = date("Y-m-d", strtotime($year . '-' . $month . '-' . $day));
        }

        return $return;
    }

}

if (! function_exists('outdate')) {

    function outdate($val, $format = 'M j, Y'){

        if($val == NULL || $val == '0000-00-00' || $val == '0000-00-00 00:00:00'){

            return '';
        }else{

            return date($format, strtotime($val));
        }

    }

}

if(!function_exists('desclist')){

    function desclist($dt, $dd, $dtclass = 'col-sm-3', $ddclass = 'col-sm-9'){

        ob_start();

        echo '<dt class="' . $dtclass . '">' . $dt . '</dt>';

        echo '<dd class="' . $ddclass . '">' . $dd . '</dd>';  

        $return = ob_get_contents();

        ob_end_clean();

        return $return;


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

        $block = AkiCreative\AkiForms\Models\Akitextblock::find($id);

        if(empty($block)){

            return false;
        }

        if($textonly){

            return $block->textblock;

        }else{

            $return = [

                'heading' => $block->heading,
                'textblock' => $block->textblock,
                'format' => $block->format

            ];

            return $return;

        }

    }

}

if (! function_exists('akiasset')) {

    function akiasset($id, $size = 'full', $obj = false)
    {

        $asset = AkiCreative\AkiForms\Models\Akiasset::find($id);

        if(empty($asset)){

            return false;
        }

        if($obj){

            return $obj;

        }else{

            if($size == 'full'){

                return asset('storage/' . $asset->serverfilename);

            }else{


                return asset('storage/' . $asset->serverfilenametn);
            }

        }

    }

}

if (! function_exists('akiasseturl')) {

    function akiasseturl($id, $mode = 'full')
    {

        $a = \AkiCreative\AkiForms\Models\Akiasset::where('id', $id)->first();

        if(empty($a)){

            return '#';
        }

        $c = \AkiCreative\AkiForms\Models\Akicategory::where('slug', $a->category)->first();

        $scope = 'public';

        if($c->private){

            $scope = 'private';
        }

        if($mode == 'full' || $a->type() != 'image'){

            $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilename);

            return route('aki.asset.' . $scope, [$id, $fn]);
        
        }else{

            $fn = preg_replace("!^(.*?\/)?!", "", $a->serverfilenametn);

            return route('aki.asset.' . $scope, [$id, $fn]);

        }
        
    }

}

if (! function_exists('akimoney')) {

    function akimoney($amount, $integer = false)
    {

        if(!$integer){

            $amount  = ($amount * 100) / 100;
        }

        $fmt = new \NumberFormatter( 'en_CA', \NumberFormatter::CURRENCY );

        return $fmt->formatCurrency($amount, "CAD");

    }

}

if (! function_exists('akidollar')) {

    function akidollar($amount, $comma = '')
    {

        return number_format($amount, 2, ".", $comma);

    }

}
