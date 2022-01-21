@props([
    'name' => ''
    'format' => ''
])

@if($format == '')

    <? $format = env('DATEFORMAT', 'MM/DD/YYYY'); ?>

@endif

<div
     x-data
     x-init="new Pikaday({ field: $refs.input, format: '{{ $format }}' })
        onSelect: function() {
            $wire.{{ $name }}db = this.getMoment().format('YYYY-MM-DD')
        }})
    "
     
     class=""
 >

     <div class="input-group input-group-sm">
      <div class="input-group-text"><i class="far fa-calendar"></i></div>



     <input
        wire:model.lazy="{{ $name }}"
         {{ $attributes }}
         x-ref="input"
         @change="$dispatch('input', $event.target.value)"
         class="form-control form-control-xs"
     />

 </div>