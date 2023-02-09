@props([

    'hideloading' => true

])

<x-aki.loading></x-aki.loading>

@if($hideloading)

<div wire:loading.remove>

@endif

<table {{ $attributes->merge(['class' => 'min-w-full']) }}>

    {{ $slot }}
    
</table>

@if($hideloading)

</div>

@endif

