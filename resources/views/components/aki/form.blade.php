@props([

    'submit' => 'save',
    'formmessage' => 'formmessage'

])

<form wire:submit.prevent='{{ $submit }}'>

    <x-formmessage formmessage="{{ $formmessage }}" />

    {{ $slot }}

</form>