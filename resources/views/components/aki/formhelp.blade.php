@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'text-sm font-semibold text-gray-400 pt-2' . ' ' . $class]); 

?>

<div {{ $attributes }}>{!! $slot !!}</div>