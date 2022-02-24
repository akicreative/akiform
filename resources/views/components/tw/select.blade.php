@props([

	'name' => '',
	'id' => '',
	'options' => [],
	'class' => '',
	'default' => '',
	'all' => false

])

@aware([
	'for' => '',
	'display' => ''
])


<?

if($id == '' && $for != ''){

	$id = $for;
}

if($display == 'inline'){

	$class = 'w-auto inline';
}

?>

<select {{ $attributes }} id="{{ $id }}" name="{{ $name }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md {{ $class }}">



			@if($all)

				<? 

				if($default === 'all')
				{

					$selected = 'selected';

				}else{

					$selected = '';

				}

				?>

				<option value="all" {{ $selected }}>{{ $all }}</option>

			@endif
	   
	    @foreach($options as $value => $option)

			<? 

			if($default === $value)
			{

				$selected = 'selected';

			}else{

				$selected = '';

			}

			?>

			<option value="{{ $value }}" {{ $selected }}>{{ $option }}</option>

		@endforeach

</select>