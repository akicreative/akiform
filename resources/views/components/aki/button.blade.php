@props([

	'type' => 'button',
	'template' => 'primary',
	'class' => '',
	'size' => 'text-base'

])



@if($template == 'create')

<?

$attributes = $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1.5 border border-transparent ' . $size . ' font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500' . ' ' . $class]); 

?>

<button {{ $attributes }} type="{{ $type }}">{{ $slot }}</button>

@elseif($template == 'white')

<?

$attributes = $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm '   . $size . ' font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500' . ' ' . $class]); 

?>

<button {{ $attributes }} type="{{ $type }}">{{ $slot }}</button>

@else

<?

$attributes = $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1.5 border border-transparent'  . $size . 'font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500' . ' ' . $class]); 

?>

<button {{ $attributes }} type="{{ $type }}">{{ $slot }}</button>


@endif