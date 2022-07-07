@props([

    'method' => '',
    'message' => ""

])



<div x-data>


    <button {{ $attributes }} class="p-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-600 rounded-md focus:outline-none focus:border-blue-300 focus:shadow-outline-blue hover:text-red-700 active:bg-red-700" 
    @if($message == '' && $method != '')

        wire:click="{{ $method }}"

    @else

        @click="confirm('{{ $message }}') ? $wire.{{ $method }} : false;"
    
    @endif
    >
        {{ $slot }}    
    </button>
</div>
