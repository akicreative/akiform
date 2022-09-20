@props([

	'class' => 'bg-gray-100',
	'align' => 'text-left'

])

<thead>

	<tr {{ $attributes->merge(['class' => 'shadow-sm sm:rounded-t-lg px-4 pt-2 text-xs font-bold  ' . $class . ' ' . $align]) }}>

{{ $slot }}

	</tr>

</thead>