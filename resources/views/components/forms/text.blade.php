@props([
	'id' => '',
	'name',
	'type' => 'text',
	'validation' => true
])

@aware([
	'for' => ''
])

<? 

$validationclass = '';

if($errors->first($for)){

	$validationclass = 'is-invalid';

}

$atts = $attributes->merge(['class' => 'form-control form-control-sm' . ' ' . $validationclass]); 

if($id == '' && $type != 'file'){

	if($for != ''){

		$atts = $atts->merge(['id' => $for]);

	}else{

		$atts = $atts->merge(['id' => $name]);

	}

}

?>


<input type="{{ $type }}"  {{ $atts }}>