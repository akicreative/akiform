@props([

    'class' => '',
    'label' => '',
    'size' => 'sm'

])


<?

$attributes = $attributes->merge(['class' => 'py-2 sm:py-2 sm:grid sm:grid-cols-3 sm:gap-4' . ' ' . $class]); 

?>

<div {{ $attributes }}>
	<dt class="text-sm font-bold text-black-900">{{ $label }}</dt>
	<dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $slot }}</dd>
</div>