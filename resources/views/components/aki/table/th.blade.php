@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'print:text-black px-3 py-2 whitespace-nowrap text-sm text-gray-900 align-top' . ' ' . $class]); 

?>

<th {{ $attributes }}>{{ $slot }}</th>
