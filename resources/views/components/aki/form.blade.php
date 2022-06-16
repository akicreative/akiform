@props([

    'submit' => 'save',
    'formmessage' => 'formmessage'

])

@if($attributes->has('wire:submit.prevent'))

    <form {{ $attributes }}>
  
@else

    <form wire:submit.prevent='{{ $submit }}' {{ $attributes->except('wire:submit.prevent') }}>

@endif

    <x-aki.formmessage formmessage="{{ $formmessage }}" />

    {{ $slot }}

</form>