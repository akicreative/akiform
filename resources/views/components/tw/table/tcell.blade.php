@props([

    'class' => 'text-sm text-gray-900 align-top',
    'type' => 'td'

])


<?

$attributes = $attributes->merge(['class' => 'px-3 py-2 whitespace-nowrap text-sm' . ' ' . $class]); 

?>

<{{ $type }} {{ $attributes }}>{{ $slot }}</{{ $type }}>
