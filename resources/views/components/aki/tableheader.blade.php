@props([

	'class' => '',
	'align' => 'text-left',
	'padding' => 'px-4 pt-2',
	'bg' => 'bg-gray-100',
	'size' => 'text-xs'
])

<thead>

	<tr {{ $attributes->merge(['class' => 'shadow-sm sm:rounded-t-lg font-bold  ' . $padding . ' ' . $class . ' ' . $align . ' ' . $bg . ' ' . $size]) }}>

{{ $slot }}

	</tr>

</thead>