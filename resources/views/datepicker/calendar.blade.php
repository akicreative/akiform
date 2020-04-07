<?

$akidp = new AkiForm($errors);

$akidp->fill(collect(['akidpmonth' => $currentmonth, 'akidpyear' => $currentyear]));

$akidp->open(['id' => 'akidpform', 'inlinelist' => true]);

$akidp->horiontal = false;

echo '<ul class="list-inline">';

echo '<li class="list-inline-item">';

echo '<button type="button" class="btn btn-sm btn-link text-dark akidpprevnext" data-month="' . $prevmonth . '" data-year="' . $prevyear . '"><<</button>';

echo '</li>';

echo '<li class="list-inline-item">';

$akidp->build('select', 'Month', 'akidpmonth', ['class' => 'akidptrigger', 'selectoptions' => montharray(), 'fieldonly' => true]);

echo '</li>';

echo '<li class="list-inline-item">';

$akidp->build('select', 'Year', 'akidpyear', ['class' => 'akidptrigger', 'selectoptions' => yeararray($yearstart, $yearend), 'fieldonly' => true]);

echo '</li>';

echo '<li class="list-inline-item">';


echo '<button type="button" class="btn btn-sm btn-link text-dark akidpprevnext" data-month="' . $nextmonth . '" data-year="' . $nextyear . '">>></button>';

echo '</li>';

echo '</ul>';

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

            }else{

                if($d < 6){

                    $totalrows = 5;
            
                }
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

        $key = $r . '-' . $d;

        $day = $val[$key];

        $showingtime = strtotime($currentyear . '-' . $currentmonth . '-' . $day);

        $showingday = date("Y-m-d", $showingtime);

        $showingdayofweek = date("w", $showingtime);

        if(date("Y-m-d") == date("Y-m-d", $showingtime)){

            $btnclass .= ' btn-primary text-white';
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

        if($showingtime < $startrange && $startrange != ''){

            $disabled = 'disabled';
        }

        if($showingtime > $endrange && $endrange != ''){

            $disabled = 'disabled';
        }


        echo '<td style="text-align: center; padding: 0;">';

        echo '<button type="button" class="btn btn-link btn-block btn-sm m-0' . $btnclass . '" style="border-radius: 0;" ' . $disabled . '>' . $val[$key] . '</button>';

        echo '</td>';

    }

    echo '</tr>';

}

echo '</table>';

echo '</div>';


$akidp->close();

?>