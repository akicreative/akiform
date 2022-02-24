@props([

	'name' => '',
	'id' => '',
	'class' => 'w-full',
	'type' => 'text'

])

@aware([
	'for' => '',
	'display' => ''
])

<? $attributes = $attributes->merge(['class' => 'mt-1 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md' . ' ' . $class]); ?>

@if($id == '' && $for != '')

	<? $id = $for; ?>

@endif

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" {{ $attributes }}>