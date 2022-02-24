@props([

	'padding' => 'p-4'

])

<div class="min-h-full mb-3 bg-white shadow-sm sm:rounded-lg {{ $padding }}">

{{ $slot }}

</div>