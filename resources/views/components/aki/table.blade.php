@props([

    'hideloading' => true

])



@if($hideloading)

<x-aki.loading></x-aki.loading>

<div wire:loading.remove>

@endif

<table {{ $attributes->merge(['class' => 'min-w-full']) }}>

    {{ $slot }}
    
</table>

@if($hideloading)

</div>

@endif

