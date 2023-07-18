@props([
    'options' => [],
    'width' => 'min-w-18 w-auto',
    'clear' => false
])

@php
    $options = array_merge([
                    'dateFormat' => 'Y-m-d',
                    'enableTime' => false,
                    'altFormat' =>  'F j, Y',
                    'altInput' => true
                    ], $options);
@endphp

<div class="mt-1 relative {{ $width }}" wire:ignore>

    <input
        x-data="{
             value: @entangle($attributes->wire('model')), 
             instance: undefined,
             init() {
                 $watch('value', value => this.instance.setDate(value, false));
                 this.instance = flatpickr(this.$refs.input, {{ json_encode((object)$options) }});
             }
        }"
        x-ref="input"
        x-bind:value="value"
        type="text"
        {{ $attributes->merge(['class' => 'bg-white block rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 ']) }}
    />

    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
      <span class="text-gray-500 sm:text-sm"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
</svg> </span>
    </div>

</div>

@if($clear) 

<x-aki.button.link wire:click="$set('{{ $clear }}', null)">clear date</x-aki.button.link>

@endif