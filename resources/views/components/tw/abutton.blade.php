@props([

	'template' => 'primary',
	'href' => '#'

])

@if($template == 'create')

<a href="{{ $href }}" {{ $attributes }} class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">{{ $slot }}</a>

@else

<a href="{{ $href }}" {{ $attributes }} class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ $slot }}</a>


@endif