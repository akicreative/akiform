@props([

    'submit' => 'save'

])

<form wire:submit.prevent='{{ $submit }}' {{ $attributes }}>

    <x-aki.formmessage />

    {{ $slot }}

</form>