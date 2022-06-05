@props([

    'submit' => 'save',
    'formmessage' => 'formmessage'

])

<form wire:submit.prevent='{{ $submit }}'>

    <x-aki.formmessage />

    {{ $slot }}

</form>