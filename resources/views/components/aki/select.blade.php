@props([

	'name' => '',
	'id' => '',
	'options' => [],
	'class' => 'block w-full',
	'padding' => 'py-2',
	'default' => '',
	'all' => false,
	'blank' => false,
	'display' => '',
	'errorfound' => false

])

@aware([
	'for' => '',
	'display' => '',
	'errorhighlight' => false
])

@error($for)

	<? $errorfound = true; ?>

@enderror

<?

if($id == '' && $for != ''){

	$id = $for;
}

if($display == 'inline'){

	$class = 'inline w-auto';

}elseif($display == 'inlinefull'){

	$class = 'inline w-full';
}

if($errorhighlight && $errorfound){

	$class .= ' border border-red-600';

}

?>

<select {{ $attributes }} id="{{ $id }}" name="{{ $name }}" class="mt-1 pl-3 pr-10 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md {{ $class }} {{ $padding }}">



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

			@if($blank)

				<? 

				if($default === '')
				{

					$selected = 'selected';

				}else{

					$selected = '';

				}

				?>

				<option value="" {{ $selected }}>{{ $blank }}</option>

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

<? /*

- Mar 11: Added blank option

*/ ?>