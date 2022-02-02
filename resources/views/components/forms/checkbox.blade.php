@props([

	'id' => '',
	'name' => '',
	'label' => '',
	'value' => '',
	'validation' => true
])

<?

$validationclass = '';

if($errors->first($for)){

	$validationclass = 'is-invalid';

}

?>

<div class="form-check {{ $validationclass }}">
  <input {{ $attributes }} name="{{ $name }}" id="{{ $id }}" class="form-check-input" type="checkbox" value="{{ $value }}">
  <label class="form-check-label" for="{{ $id }}">
    {{ $label }}
  </label>
</div>
