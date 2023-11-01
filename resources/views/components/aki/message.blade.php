@props([

    'colour' => 'green'

])

<?

$green = false;
$red = false;

switch($colour){

    case "green":
        $green = true;
        break;
    case "red":
        $red = true;
        break;
}

?>

@if($slot != '')

<div x-data="{ showalert: true }">

    <div x-show="showalert" x-effect="if(showalert) setTimeout(function() {showalert = false}, 10000)" style="display: none" class="block pt-2 pb-3">


    <div @class([
        'px-4',
        'py-2',
        'rounded-md',
        'shadow-sm',
        'bg-green-50' => $green,
        'bg-red-50' => $red

    ])>
        <div class="flex">
          <div class="flex-shrink-0">

          </div>
          <div class="">
            <p @class([
                'text-sm',
                'font-medium',
                'text-green-800' => $green,
                'text-red-800' => $red

            ])>{{ $slot }}</p>
          </div>
          <div class="pl-3 ml-auto">
            <div class="-mx-1.5 -my-1.5">
              <button type="button" @click="showalert = false"
              @class([
                'inline-flex',
                'rounded-md',
                'bg-green-50' => $green,
                'bg-red-50' => $red,
                'p-1.5',
                'text-green-500' => $green,
                'text-red-500' => $red,
                'hover:bg-green-100' => $green,
                'hover:bg-red-100' => $red,
                'focus:outline-none',
                'focus:ring-2',
                'focus:ring-green-600' => $green,
                'focus:ring-red-600' => $red,
                'focus:ring-offset-2',
                'focus:ring-offset-green-50' => $green,
                'focus:ring-offset-red-50' => $red
              ])>
                <span class="sr-only">Dismiss</span>
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>

</div>

@endif
