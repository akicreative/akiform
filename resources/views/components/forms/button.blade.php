@props([

	'id' => '',
	'label' => 'Submit',
	'type' => 'submit',
	'class' => 'btn-primary',
	'size' => 'btn-xs'
])



<? 

$atts = $attributes->merge(['class' => 'btn ' . $size . ' ' . $class]); 

if($id == '' && $atts->has('name')){

	$atts = $atts->merge(['id' => $atts->get('name')]);
}

?>


<button type="{{ $type }}" {{ $atts }}>{{ $label }}</button>