@props([

	'class' => 'bg-white'

])

<tr {{ $attributes->merge(['class' => 'table-row ' . $class]) }}>

{{ $slot }}

</tr>