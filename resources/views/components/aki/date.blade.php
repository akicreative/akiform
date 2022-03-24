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
        class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <!-- Heroicon name: solid/mail -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
</svg>
    </div>
    <input {{ $attributes }}
        type="text"
         x-ref="input"
         @change="$dispatch('input', $event.target.value)" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 sm:text-sm border-gray-300 rounded-md w-auto">
  </div>