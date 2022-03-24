@props(['options' => []])

@php
    $options = array_merge([
                    'dateFormat' => 'Y-m-d',
                    'enableTime' => false,
                    'altFormat' =>  'F j, Y',
                    'altInput' => true
                    ], $options);
@endphp

<div wire:ignore>
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
        {{ $attributes->merge(['class' => 'bg-white mt-1 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md']) }}
    />
</div>