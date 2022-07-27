@props([

    'method' => '',
    'message' => "",
    'type' => 'button'

])

<div x-data>


    <button {{ $attributes->merge(['class' => 'p-2 text-sm font-bold leading-4 text-gray-500 transition duration-150 ease-in-out border border-gray-600 rounded-md hover:bg-blue-200 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue hover:text-blue-700 active:bg-blue-700']) }}
    @if($message == '' && $method != '')

        wire:click="{{ $method }}"

    @elseif($message != '' && $method != '')

        @click="confirm('{{ $message }}') ? $wire.{{ $method }} : false;"
    
    @endif

        type="{{ $type }}"

    >
        {{ $slot }}    
    </button>
</div>
