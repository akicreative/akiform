@props([

	'id' => '',
	'name',
	'type' => 'text'
])



<? 

$atts = $attributes->merge(['class' => 'form-control form-control-sm']); 

if($id == ''){

	$atts = $atts->merge(['id' => $name]);
}

?>


<input type="{{ $type }}"  {{ $atts }}>