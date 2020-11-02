<?php

if (! function_exists('akiredactorxcss')) {

    function akiredactorxcss() {
        
        echo '<link rel="stylesheet" href="' . url('/vendor/akicreative/akiforms/redactorx/redactorx.min.css') . '">';
    }
}

if (! function_exists('akiredactorxplugins')) {

    function akiredactorxplugins($exclude = [], $include = []) {

        $names = ['alignment', 'blockcode', 'definedlinks', 'handle', 'icons', 'imageposition', 'inlineformat', 'removeformat', 'selector', 'underline'];

        for($i = 0; $i < count($exclude); $i++){

            $key = $exclude[$i];

            unset($names[$key]);

        }

        for($i = 0; $i < count($include); $i++){

            $key = $include[$i];

            $name[] = $key;

        }

        echo '<script src="' . url('/vendor/akicreative/akiforms/redactorx/redactorx.min.js') . '"></script>';

        foreach($names as $name){

            echo '<script src="' . url('/vendor/akicreative/akiforms/redactorx/plugins/' . $name . '/' . $name . '.min.js') . '"></script>';
        }

        return $names;

           
    }

}

if (! function_exists('akiredactorxjs')) {

    function akiredactorxjs($plugins, $params = []) {

        /*

        //$buttons = ['format', 'bold', 'italic', 'deleted', 'lists', 'link'];
        $fileupload = '';
        $imageupload = '';
        $allplugins = false;
        $pluginadd = [];
        $pluginremove = [];
        $buttonadd = [];
        $buttonremove = [];

        */

        $cfg = [

            'target' => '.redactor',
            'source' => 'true',
            'control' => 'true',
            'autosave' => '',
            'more' => []

        ];

        foreach($params as $key => $value){

            $cfg[$key] = $value;

        }

        /*
        

        $vars = ["linkNewTab: true"];

        if(count($plugins) > 0){

            $vars[] = "plugins: ['" . implode("', '", $plugins) . "']";
        } 

        $vars[] = "buttons: ['" . implode("', '", $buttons) . "']";

        */

        $settings = [];

        $settings[] = "plugins: ['" . implode("', '", $plugins) . "']";

        $settings[] = 'source: ' . $cfg['source'];

        $settings[] = 'control: ' . $cfg['control'];

        if($cfg['autosave'] != ''){

            $settings[] = "autosave: { url: '" . $cfg['autosave'] . "'}";
        }

        if(count($cfg['more']) > 0){

            foreach($cfg['more'] as $val){

                $settings[] = $val;

            }

        }

        echo '<script type="text/javascript">

        (function(){
            
            RedactorX("' . $cfg['target'] . '", {' . implode(", ", $settings) . ' })';

        echo '

        })();

        </script>

        ';

        
    }

}