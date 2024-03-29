@props([
    'name' => '',
    'format' => ''
])

@if($format == '')

    <? $format = env('DATEFORMAT', 'MM/DD/YYYY'); ?>

@endif

<div
     x-data
     x-init="new Pikaday({ field: $refs.input, format: '{{ $format }}' })"
     
     class=""
 >

     <div class="input-group input-group-sm">
      <div class="input-group-text"><i class="far fa-calendar"></i></div>



     <input
         {{ $attributes }}
         x-ref="input"
         @change="$dispatch('input', $event.target.value)"
         class="form-control form-control-sm"
     />

 </div>

 </div>