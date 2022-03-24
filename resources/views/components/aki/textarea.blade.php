@props([

	'id' => '',
	'name' => '',
	'rows' => 4,
	'label' => ''
])

@aware([
	'for' => '',
	'display' => ''
])

<? 

$atts = $attributes->merge(['class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mb-3']); 

if($id == '' && $name != ''){

	$atts = $atts->merge(['id' => $name]);
}

if($for == ''){

	$for = $id;
}

?>

@if($label != '')
<div>
  <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
  <div class="mt-1">
@endif
    <textarea {{ $atts }} rows="{{ $rows }}" name="{{ $name }}" id="{{ $id }}">{{ old($name, $slot) }}</textarea>
@if($label != '')
  </div>
</div>

@endif