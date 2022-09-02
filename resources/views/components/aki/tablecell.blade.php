@props([

    'label' => ''

])

<td {{ $attributes->merge(['class' => 'p-2']) }}>

@if($label != '')

<div class="text-xs text-gray-500 md:hidden">{{ $label }}</div>

@endif

{{ $slot }}

</td>