@props([
	'display' => 'vertical',
	'for' => '',
	'label' => '',
	'labelclass' => 'text-sm font-bold text-gray-700',
	'name' => '',
	'id' => '',
])

@if($display == 'vertical')

	<div>
  	<label for="{{ $for }}" class="block {{ $labelclass }}">{{ $label }}</label>

@elseif($display == 'horizontal')
  	
  	<div class="space-y-6 sm:space-y-5">
		<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:pt-2 {{ $labelclass }}"> {{ $label }} </label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-2">
@endif

 {{ $slot }}

@if($display == 'vertical')

  		<x-akiforms::tw.error />

	</div>

@elseif($display == 'horizontal')
  	
			<x-akiforms::tw.error />

			</div>

		</div>

	</div>

@endif