@props([

    'class' => '',
    'bg' => 'bg-white',
   	'labelposition' => 'bottom',
   	'label' => ''

])


<?

$attributes = $attributes->merge(['class' => 'p-2' . ' ' . $class]); 

?>

<div class="{{ $bg }} p-2">

	@if($labelposition != 'bottom')

		<dt class="text-xs font-bold text-gray-400">{{ $label }}</dt>
	@endif
          
  <dd class="mt-1 text-base text-black-900">{!! $slot !!}</dd>
  
  	@if($labelposition == 'bottom')

		<dt class="text-xs font-bold text-gray-400">{{ $label }}</dt>
	@endif

</div>