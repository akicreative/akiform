@props([

    'class' => '',
    'border' => ''

])


<?

$attributes = $attributes->merge(['class' => 'sm:divide-y sm:divide-gray-200' . ' ' . $class]); 

?>

<div class="{{ $border }} p-0">
<dl {{ $attributes }}>

	{{ $slot }}

</dl>
</div>