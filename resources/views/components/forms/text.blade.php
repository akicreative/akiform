@props([

	'id' => '',
	'name',
	'type' => 'text'
])



<? 

$atts = $attributes->merge(['class' => 'form-control form-control-sm']); 

if($id == '' && $atts->has('name')){

	$atts = $atts->merge(['id' => $atts->get('name')]);
}

?>


<input type="{{ $type }}" wire:model="{{ $name }}" {{ $atts }}>