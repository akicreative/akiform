@props([

  'type' => 'success'


])

<?

switch($type){

  case "alert":
    $color = 'red';
    break;
  default:
    $color = 'green';
    break;


}

?>

<div
 	class="rounded-md bg-{{ $color }}-50 p-3 mb-3">
  <div class="flex">
    <div class="flex-shrink-0">
      @if($type == "alert")
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      @else
      <!-- Heroicon name: solid/check-circle -->
      <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      @endif
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-{{ $color }}-800">{{ $slot }}</p>
    </div>
    <? /*
    <div class="pl-3 ml-auto">
      <div class="-mx-1.5 -my-1.5">
        <button @click="open = false" type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
          <span class="sr-only">Dismiss</span>
          <!-- Heroicon name: solid/x -->
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

    */ ?>
  </div>
</div>