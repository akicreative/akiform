@props([

	'id' => '',
	'name' => '',
	'label' => '',
	'value' => '',
	'comments' => ''
])

<div class="relative flex items-start">
    <div class="flex items-center h-5">
       <input {{ $attributes }} id="{{ $id }}" name="{{ $name }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" type="checkbox" value="{{ $value }}">
    </div>
    <div class="ml-2 text-sm">
      <label for="{{ $id }}" class="font-medium text-gray-700">{{ $label }}</label>
      @if($comments != '')
      <p id="{{ $id }}-description" class="text-gray-500">{!! $comments !!}</p>
      @endif
    </div>
  </div>