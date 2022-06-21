@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'text-sm font-semibold text-gray-400 pt-1' . ' ' . $class]); 

?>

<div {{ $attributes }}>{!! $slot !!}</div>