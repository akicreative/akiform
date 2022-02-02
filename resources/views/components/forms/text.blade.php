@props([

	'id' => '',
	'name',
	'type' => 'text',
	'validation' => true
])



<? 

$validationclass = '';

if($errors->first($id)){

	$validationclass = 'is-invalid';

}

$atts = $attributes->merge(['class' => 'form-control form-control-sm' . ' ' . $validationclass]); 

if($id == '' && $type != 'file'){

	$atts = $atts->merge(['id' => $name]);
}

?>


<input type="{{ $type }}"  {{ $atts }}>