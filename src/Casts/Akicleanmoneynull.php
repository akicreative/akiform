<?php

namespace AkiCreative\AkiForms\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Akicleanmoneynull implements CastsAttributes
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
        
        if($value == null){

            return '';
        }

		return $value / 100;
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

        if($value == '' || $value == NULL){

            $value = '';
        }

        $value = preg_replace("![^0-9\.\-]+!", "", $value);

        $value = (float)$value;

    	return (int)(round($value * 100));
    }
}