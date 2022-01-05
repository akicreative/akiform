@props([

	'type' => 'danger',
	'padding' => 'p-2'

])

<div class="alert alert-{{ $type }} mb-3 {{ $padding }}">

{{ $slot }}

</div>