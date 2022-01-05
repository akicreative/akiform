@props([

	'id' => '',
	'label' => 'Submit',
	'type' => 'submit',
	'class' => 'btn-primary'
])



<? 

$atts = $attributes->merge(['class' => 'btn btn-sm ' . $class]); 

if($id == '' && $atts->has('name')){

	$atts = $atts->merge(['id' => $atts->get('name')]);
}

?>


<button type="{{ $type }}" {{ $atts }}>{{ $label }}</button>