@props([

    'class' => '',
    'type' => 'td'

])


<?

$attributes = $attributes->merge(['class' => 'px-3 py-2 whitespace-nowrap text-sm text-gray-900 align-top' . ' ' . $class]); 

?>

<{{ $type }} {{ $attributes }}>{{ $slot }}</{{ $type }}>
