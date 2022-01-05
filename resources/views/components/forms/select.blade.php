@props([

	'id' => '',
	'name',
	'options' => [],
	'default' => ''
])



<? 

$atts = $attributes->merge(['class' => 'form-control form-control-sm']); 

if($id == '' && $atts->has('name')){

	$atts = $atts->merge(['id' => $atts->get('name')]);
}

?>


<select wire:model="{{ $name }}" {{ $atts }}>

	@foreach($options as $value => $label)

		<? 

		if($default === $value)
		{

			$selected = 'selected';

		}else{

			$selected = '';

		}

		?>

		<option value="{{ $value }}" {{ $selected }}>{{ $label }}</option>

	@endforeach

</select>