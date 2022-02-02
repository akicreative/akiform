@props([

	'id' => '',
	'name' => '',
	'options' => [],
	'default' => ''
])



<? 

$atts = $attributes->merge(['class' => 'form-select form-select-sm']); 

if($id == '' && $name != ''){

	$id = $name;
}

?>


<select {{ $atts }} id="{{ $id }}" name="{{ $name }}">

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