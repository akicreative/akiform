@props([

	'class' => 'bg-gray-100'

])

<thead>

	<tr {{ $attributes->merge(['class' => 'shadow-sm sm:rounded-t-lg px-4 pt-2 text-sm font-bold  ' . $class]) }}>

{{ $slot }}

	</tr>

</thead>