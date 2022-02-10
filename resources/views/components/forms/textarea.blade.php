@props([

	'id' => '',
	'name' => '',
	'rows' => 5
])



<? 

$atts = $attributes->merge(['class' => 'form-control form-control-sm']); 

if($id == '' && $name != ''){

	$atts = $atts->merge(['id' => $name]);
}

?>


<textarea name="{{ $name }}" {{ $atts }} rows="{{ $rows }}">{{ old($name, $slot) }}</textarea>