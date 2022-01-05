@props([

	'id' => '',
	'name',
	'rows' => 5
])



<? 

$atts = $attributes->merge(['class' => 'form-control form-control-sm']); 

if($id == '' && $atts->has('name')){

	$atts = $atts->merge(['id' => $atts->get('name')]);
}

?>


<textarea wire:model="{{ $name }}" {{ $atts }} rows="{{ $rows }}">
</textarea>