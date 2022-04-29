@props([

  'type' => 'success',
  'icon' => true


])


@if($type == "alert")
     
      <div
  class="rounded-md bg-red-50 p-3 mb-3">
  

        @if($icon)

        <div class="flex">
        <div class="flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          </div>
        <div class="ml-3">

          @endif

      <p class="text-sm font-medium text-red-800">
     

      @else
     

      <div class="rounded-md bg-green-50 p-3 mb-3">

         @if($icon)

      <div class="flex">
        <div class="flex-shrink-0">
          <!-- Heroicon name: solid/check-circle -->
          <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          </div>
        <div class="ml-3">

          @endif

      <p class="text-sm font-medium text-green-800">
    
      @endif
    
    {{ $slot }}

    </p>

    @if($icon)

      </div>
      
    </div>

    @endif

</div>