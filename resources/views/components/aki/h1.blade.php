@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'text-2xl font-semibold text-gray-900' . ' ' . $class]); 

?>

<h2 {{ $attributes }}>{{ $slot }}</h2>