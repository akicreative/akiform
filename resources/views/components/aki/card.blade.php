@props([

	'padding' => 'p-4',
	'class' => 'bg-white',
	'border' => 'border border-gray-600'

])

<?

$attributes = $attributes->merge(['class' => 'mb-3 shadow-sm sm:rounded-lg' . ' ' . $padding . ' ' . $class . ' ' . $border]); 

?>

<div {{ $attributes }}>

{{ $slot }}

</div>