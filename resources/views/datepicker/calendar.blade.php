<?

$akidp = new AkiForm($errors);

$akidp->fill(collect(['akidpmonth' => $currentmonth, 'akidpyear' => $currentyear]));

$akidp->open(['id' => 'akidpform', 'inlinelist' => true]);

$akidp->horiontal = false;

echo '<div class="mb-3" style="text-align: center;">';

echo '<ul class="list-inline my-auto">';

echo '<li class="list-inline-item">';

echo '<button type="button" name="prevnext" class="btn btn-sm btn-link text-dark akidpprevnext" value="' . $prev . '"><<</button>';

echo '</li>';

echo '<li class="list-inline-item">';

$akidp->build('select', 'Month', 'akidpmonth', ['class' => 'akidptrigger', 'selectoptions' => montharray(), 'fieldonly' => true]);

echo '</li>';

echo '<li class="list-inline-item">';

$akidp->build('select', 'Year', 'akidpyear', ['class' => 'akidptrigger', 'selectoptions' => yeararray($yearstart, $yearend), 'fieldonly' => true]);

echo '</li>';

echo '<li class="list-inline-item">';


echo '<button type="button" name="prevnext" class="btn btn-sm btn-link text-dark akidpprevnext" value="' . $next . '">>></button>';

echo '</li>';

echo '</ul>';

echo '</div>';

echo '<div id="akidpcalendar">';

echo <<<EOT

<table class="table table-bordered table-sm">
<tr>

    <th style="width: 14%; text-align: center;">S</th>
    <th style="width: 14%; text-align: center;">M</th>
    <th style="width: 14%; text-align: center;">T</th>
    <th style="width: 14%; text-align: center;">W</th>
    <th style="width: 14%; text-align: center;">T</th>
    <th style="width: 14%; text-align: center;">F</th>
    <th style="width: 14%; text-align: center;">S</th>
</tr>

EOT;



$day = 1;

$totalrows = 6;

$val = [];

for($r = 1; $r <= $totalrows; $r++){

    for($d = 0; $d < 7; $d++){

        $v = '';

        if(($r == 1 && $d >= $currentfirstdayofweek) || $r > 1){

            if($day <= $currentlastdayofmonth){

                $v = $day;

            }

            $day++;
        }

        $key = $r . '-' . $d;

        $val[$key] = $v;

    }


}

for($r = 1; $r <= $totalrows; $r++){

    echo '<tr>';

    for($d = 0; $d < 7; $d++){

        $btnclass = '';
        $disabled = '';
        $disabledbg = '';

        $key = $r . '-' . $d;

        $day = $val[$key];

        $datetext = '';
        
        if($day != ''){

	        $showingtime = strtotime($currentyear . '-' . $currentmonth . '-' . $day);

	        $showingday = date("Y-m-d", $showingtime);

	        $showingdayofweek = date("w", $showingtime);


	        if(date("Y-m-d") == date("Y-m-d", $showingtime)){

	            if($default == $showingday){

	            	$btnclass .= ' btn-success text-white';
	            }else{

	            	$btnclass .= 'text-primary';
	            }
	        
	        }else{

	        	//echo $default . ' - ' . $showingday . '<br>';

		        if($default == $showingday){

		        	$btnclass .= ' btn-success text-white';

		        }else{

		        	$btnclass .= ' text-dark';
		        }

	    	}

	        if(in_array($showingday, $excludedays)){

	            $disabled = 'disabled';

	        }

	        if(in_array('weekdays', $excludedays) && in_array($showingdayofweek, [1, 2, 3, 4, 5])){

	            $disabled = 'disabled';

	        }

	        if(in_array('weekends', $excludedays) && in_array($showingdayofweek, [0, 6])){

	            $disabled = 'disabled';

	        }

	        if(in_array($showingdayofweek, $excludedays)){

	            $disabled = 'disabled';

	        }

	        if($showingtime < strtotime($startrange) && $startrange != ''){

	            $disabled = 'disabled';
	        }

	        if($showingtime > strtotime($endrange) && $endrange != ''){

	            $disabled = 'disabled';
	        }

	        $display = outdate($showingday, $datepickerformat);
	        $sql = $showingday;

	        if($disabled == 'disabled'){

	        	$disabledbg = 'background-color: #E9E9E9;';
	        }

	        if($bootstrapversion == 5){

	        	$datetext = '<div class="d-grid"><button type="button" class="btn btn-link btn-sm akidpset m-0' . $btnclass . '" style="border-radius: 0;" data-target="' . $target . '" data-display="' . $display . '" data-sql="' . $sql . '" ' . $disabled . '><strong>' . $val[$key] . '</strong></button></div>';


	        }else{

	        	$datetext = '<button type="button" class="btn btn-link btn-block btn-sm akidpset m-0' . $btnclass . '" style="border-radius: 0;" data-target="' . $target . '" data-display="' . $display . '" data-sql="' . $sql . '" ' . $disabled . '><strong>' . $val[$key] . '</strong></button>';

	    	}

    	}

    	echo '<td style="text-align: center; padding: 0; ' . $disabledbg . '">';

    	echo $datetext;

        echo '</td>';

    }

    echo '</tr>';

}

echo '</table>';

echo '</div>';

$akidp->hidden('value', $value);
$akidp->hidden('default', $default);
$akidp->hidden('target', $target);
$akidp->hidden('yearstart', $yearstart);
$akidp->hidden('yearend', $yearend);
$akidp->hidden('startrange', $startrange);
$akidp->hidden('endrange', $endrange);
$akidp->hidden('exclude', $exclude);
$akidp->hidden('datepickerformat', $datepickerformat);

$akidp->close();

?>