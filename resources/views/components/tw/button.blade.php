@props([

	'type' => 'button',
	'template' => 'primary',
	'class' => ''

])



@if($template == 'create')

<?

$attributes = $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500' . ' ' . $class]); 

?>

<button {{ $attributes }} type="{{ $type }}">{{ $slot }}</button>

@else

<?

$attributes = $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500' . ' ' . $class]); 

?>

<button {{ $attributes }} type="{{ $type }}">{{ $slot }}</button>


@endif