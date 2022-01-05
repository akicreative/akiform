@props([

	'for' => '',
	'label' => false,
	'blockhelp' => false,
	'error' => false,
	'display' => false,
	'hleft' => 'col-sm-3',
	'hright' => 'col-sm-9'

])

<?

if($errors->first($for)){

	$error = $errors->first($for);

}

?>

<div class="mb-2 {{ $display ? 'row' : '' }}">

	@isset($label)

	 <label for="{{ $for }}" class="{{ $display ? $hleft . ' col-form-label' : 'form-label' }}">{{ $label }}</label>

	@endisset

	@if($display)

		<div class="{{ $hright . ' col-form-label' }}">

	@endif

	{{ $slot }}

	@if($blockhelp)

		<div class="text-muted my-1">{{ $blockhelp }}</div>

	@endif

	@if($error)

		<div class="mt-1 text-danger">{{ $error }}</div>

	@endif

	@if($display)

		</div>

	@endif

</div>