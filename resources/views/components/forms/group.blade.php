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

switch($display){

	case "horizontal":
		$labelclass = $hleft . ' col-form-label';
		$groupclass = 'mb-2 row';
		break;
	case "floating":
		$labelclass = '';
		$groupclass = 'form-group form-floating';
		break;
	default:
		$labelclass = 'form-label';
		$groupclass = 'mb-2';
		break;
}

?>

<div class="{{ $groupclass }}">

	@isset($label)

	 <label for="{{ $for }}" class="{{ $labelclass }}">{{ $label }}</label>

	@endisset

	@if($display == "horizontal")

		<div class="{{ $hright . ' col-form-label' }}">

	@endif

	{{ $slot }}

	@if($blockhelp)

		<div class="text-muted my-1">{{ $blockhelp }}</div>

	@endif

	@if($error)

		<div class="mt-1 text-danger">{{ $error }}</div>

	@endif

	@if($display == 'horizontal')

		</div>

	@endif



</div>