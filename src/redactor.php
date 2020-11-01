<?php

if (! function_exists('akiredactorcss')) {

    function akiredactorcss() {
        
        echo '<link rel="stylesheet" href="' . url('/vendor/akicreative/akiforms/redactorx/redactorx.min.css') . '">';
    }
}

if (! function_exists('akiredactorplugins')) {

    function akiredactorplugins($exclude = [], $include = []) {

        $names = ['alignment', 'blockcode', 'definedlinks', 'handle', 'icons', 'imageposition', 'inlineformat', 'removeformat', 'selector', 'underline'];

        foreach($i = 0; $i < count($exclude); $i++){

            $key = $exclude[$i];

            unset($names[$key]);

        }

        foreach($i = 0; $i < count($include); $i++){

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

if (! function_exists('akiredactorjs')) {

    function akiredactorjs($plugins, $params = []) {

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

            'target' => '.redactor'

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

        echo '<script type="text/javascript">

        (function(){
            RedactorX(' . $cfg['target'] . ')
        ';

        echo '

        })();

        </script>

        ';


        }
        
    }

}

