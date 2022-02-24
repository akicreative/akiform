@props([

    'class' => '',
    'border' => 'border-t border-gray-200'

])


<?

$attributes = $attributes->merge(['class' => 'sm:divide-y sm:divide-gray-200' . ' ' . $class]); 

?>

<div class="{{ $border }} p-0">
<dl {{ $attributes }}>

	{{ $slot }}

</dl>
</div>