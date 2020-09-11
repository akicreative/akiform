<?php

namespace AkiCreative\AkiForms\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Akicleanphone implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        
    	$text = preg_replace("![^0-9]+!", "", $value);

    	if($text == '') return '';

    	$text = preg_replace("!^1!", "", $text);

		$num1 = substr($text, 0, 3);

		$num2 = substr($text, 3, 3);

		$num3 = substr($text, 6, 4);

		$ext = substr($text, 10);

		if(true){

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

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {

    	return preg_replace("![^0-9]+!", "", $value);
    }
}