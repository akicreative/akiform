@props([

    'method' => '',
    'message' => "Are you sure?",
    'type' => 'button'

])

@if($method != '')

<div x-data>


    <button type="{{ $type }}" class="p-2 text-sm font-medium leading-5 text-red-500 transition duration-150 ease-in-out bg-white border border-red-600 rounded-md focus:outline-none focus:border-blue-300 focus:shadow-outline-blue hover:bg-red-300 active:bg-red-700" @click="confirm('{{ $message }}') ? $wire.{{ $method }} : false;">
        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
    </svg>
        {{ $slot }}
    </button>
</div>

@endif