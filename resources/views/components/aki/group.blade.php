@props([
	'display' => 'vertical',
	'for' => '',
	'label' => '',
	'labelclass' => 'text-sm font-bold text-gray-700',
	'labelnote' => '',
	'name' => '',
	'id' => '',
	'formhelp' => '',
	'class' => '',
	'errormsg' => '',
	'errorhighlight' => false,
	'cols' => 3,
	'span' => 2
])

<? /* sm:border-t sm:border-gray-200 */ 

$labelspan = $cols - $span;

?>

@if($display == 'vertical')

	<div>
  	<label for="{{ $for }}" class="block {{ $labelclass }}">{{ $label }}</label>

@elseif($display == 'horizontal')
  	
  	<div class="pt-2 pb-1 space-y-2 md:pt-0 sm:space-y-1">
		<div class="sm:grid sm:grid-cols-{{ $cols }} sm:gap-4 sm:items-start sm:pt-3">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:pt-2 sm:col-span-{{ $labelspan }} {{ $labelclass }}"> {{ $label }} 

				{!! $labelnote !!}

			</label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-{{ $span }}">

@elseif($display == 'horizontaltight')
  	
  	<div class="space-y-0 sm:space-y-0">
		<div class="sm:grid sm:grid-cols-{{ $cols }} sm:gap-4 sm:items-start sm:pt-0">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:pt-2 sm:col-span-{{ $labelspan }} {{ $labelclass }}"> {{ $label }} 

				{!! $labelnote !!}

			</label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-{{ $span }}">

@elseif($display == 'horizontalhover')
  	
  	<div class="px-2 space-y-0 rounded sm:space-y-0 hover:bg-gray-50">
		<div class="sm:grid sm:grid-cols-{{ $cols }} sm:gap-4 sm:items-start sm:pt-0">
			<label for="{{ $for }}" class="block text-sm sm:mt-px sm:py-3 sm:border-bottom border-none sm:col-span-{{ $labelspan }} {{ $labelclass }}"> {{ $label }} 

				{!! $labelnote !!}

			</label>
	  		<div class="mt-1 sm:mt-0 sm:col-span-{{ $span }}">

@elseif($display == 'labelbelow')

  	
	<div>
	

@endif

 {{ $slot }}

 @if($errormsg != 'hidden')

 <x-aki.error />

 @endif


 @if(in_array($display, ['vertical', 'horizontal', 'horizontaltight', 'horizontalhover', 'labelbelow']))

 
 
	@if($formhelp != '')

	<x-aki.formhelp>{!! $formhelp !!}</x-aki.formhelp>

	@endif

	@if($display == 'labelbelow')



	<? if($labelclass == 'text-sm font-bold text-gray-700'){

		$labelclass = 'text-xs font-bold text-gray-500 mt-1 ml-1';

	}

	?>

<label for="{{ $for }}" class="block {{ $labelclass }}">{{ $label }}</label>


	@endif

	</div>

 @endif

@if($display == 'horizontal' || $display == 'horizontaltight' || $display == 'horizontalhover')
  	
		</div>

	</div>

@endif