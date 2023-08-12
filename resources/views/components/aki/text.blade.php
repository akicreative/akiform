@props([

	'name' => '',
	'id' => '',
	'class' => 'w-full',
	'type' => 'text',
	'autofocus' => true,
	'errorfound' => false

])

@aware([
	'for' => '',
	'display' => '',
	'errorhighlight' => false
])

@error($for)

	<? $errorfound = true; ?>

@enderror

<? 

$showmoney = false;

if($type == 'money'){

	$class .= ' text-right pl-7';
	$type = 'text';

	$showmoney = true;

}

if($errorhighlight && $errorfound){

	$class .= ' border border-red-600';

}

if($type == 'file'){

	$attributes = $attributes->merge(['class' => 'mt-1 block focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 ' . ' ' . $class]); 

}else{

	$attributes = $attributes->merge(['class' => 'mt-1 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md' . ' ' . $class]); 

}

?>

@if($id == '' && $for != '')

	<? $id = $for; ?>

@endif

@if($showmoney)

<div class="relative mt-1">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
      <span class="text-gray-500 sm:text-sm"> $ </span>
    </div>
    <input type="text" name="{{ $name }}" id="{{ $id }}" {{ $attributes }} placeholder="0.00" aria-describedby="price-currency"

    @if($autofocus)
	  onfocus="this.select();" onmouseup="return false;"
	  @endif


    >
  </div>

@else


<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" 
  	@if($autofocus)
	  onfocus="this.select();" onmouseup="return false;"
	  @endif


{{ $attributes }}>



@endif