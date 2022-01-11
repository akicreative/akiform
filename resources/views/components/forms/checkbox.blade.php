@props([

	'id' => '',
	'name' => '',
	'label' => '',
	'value' => ''
])

<div class="form-check">
  <input {{ $attributes }} name="{{ $name }}" class="form-check-input" type="checkbox" value="{{ $value }}">
  <label class="form-check-label" for="{{ $id }}">
    {{ $label }}
  </label>
</div>
