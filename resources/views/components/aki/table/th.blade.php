@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'px-3 py-2 whitespace-nowrap text-sm text-gray-900 align-top' . ' ' . $class]); 

?>

<th {{ $attributes }}>{{ $slot }}</th>
