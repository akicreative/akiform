@props([

    'label' => '',
    'padding' => 'p-2'

])

<td {{ $attributes->merge(['class' => $padding . ' align-top']) }}>

@if($label != '')

<div class="text-xs text-gray-500 md:hidden ">{{ $label }}</div>

@endif

{{ $slot }}

</td>