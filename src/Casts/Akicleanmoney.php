<?php

namespace AkiCreative\AkiForms\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Akicleanmoney implements CastsAttributes
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

            return 0;
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

        $value = preg_replace("![^0-9\.\-]+!", "", $value);

    	return (int)($value * 100);
    }
}