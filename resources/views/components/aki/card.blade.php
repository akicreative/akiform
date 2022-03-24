@props([

	'padding' => 'p-4',
	'class' => 'bg-white'

])

<?

$attributes = $attributes->merge(['class' => 'mb-3 shadow-sm sm:rounded-lg' . ' ' . $padding . ' ' . $class]); 

?>

<div {{ $attributes }}>

{{ $slot }}

</div>