@props([
	'display' => 'vertical',
	'for' => '',
	'label' => '',
	'labelclass' => 'text-sm font-bold text-gray-700',
	'name' => '',
	'id' => '',
	'formhelp' => '',
	'class' => '',
	'errormsg' => '',
	'cols' => 3,
	'span' => 2
])

<? /* sm:border-t sm:border-gray-200 */ 
?>

@if($display == 'vertical')

	<div>
  	<label for="{{ $for }}" class="block {{ $labelclass }}">{{ $label }}</label>

@elseif($display == 'horizontal')
  	
  	<div class="space-y-2 sm:space-y-2">
		<div class="sm:grid sm:grid-cols-{{ $cols }} sm:gap-4 sm:items-start sm:pt-3">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:pt-2 {{ $labelclass }}"> {{ $label }} </label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-{{ $span }}">

@elseif($display == 'horizontaltight')
  	
  	<div class="space-y-0 sm:space-y-0">
		<div class="sm:grid sm:grid-cols-{{ $cols }} sm:gap-4 sm:items-start sm:pt-0">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:pt-2 {{ $labelclass }}"> {{ $label }} </label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-{{ $span }}">

@elseif($display == 'horizontaltightlines')
  	
  	<div class="space-y-0 sm:space-y-0">
		<div class="sm:grid sm:grid-cols-{{ $cols }} sm:gap-4 sm:items-start sm:pt-0">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:py-2 border-top border-bottom {{ $labelclass }}"> {{ $label }} </label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-{{ $span }}">
@endif

 {{ $slot }}

 <x-aki.error />

 @if(in_array($display, ['vertical', 'horizontal', 'horizontaltight']))

 
 
	@if($formhelp != '')

	<x-aki.formhelp>{!! $formhelp !!}</x-aki.formhelp>

	@endif

	</div>

 @endif

@if($display == 'horizontal' || $display == 'horizontaltight' || $display == 'horizontaltightlines')
  	
		</div>

	</div>

@endif