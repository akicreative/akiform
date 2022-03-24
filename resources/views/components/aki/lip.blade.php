@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'py-2' . ' ' . $class]); 

?>

<li {{ $attributes }}>{{ $slot }}</li>