@props([

	'message' => ''

])

<div class="min-h-full p-4 mb-3 bg-white shadow-sm sm:rounded-lg">

	<form {{ $attributes }}>

		<div class="space-y-4">

		{{ $slot }}

	</div>

	</form>

</div>