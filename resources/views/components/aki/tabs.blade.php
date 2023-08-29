@props([

    'active' => '',
    'items' => []
])

@if(count($items) > 0)

<div class="mb-3 md:tw-mb-3">


<div>
    <div class="md:hidden md:tw-hidden" x-data="{ tabshow: false }">


       <button type="button" @click="tabshow = !tabshow" class="block w-full px-2 py-1 mb-2 font-bold border rounded padding hover:bg-gray-100 tw-block tw-w-full tw-px-2 tw-py-1 tw-mb-2 tw-font-bold tw-border tw-padding hover:tw-bg-gray-100 tw-rounded"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-auto">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
      </button>


        <nav x-show="tabshow" class="flex flex-col flex-1 tw-flex tw-flex-col tw-flex-1" style="display: none;" aria-label="Navbar">
            <ul role="list" class="-mx-2 space-y-1 tw--mx-2 tw-space-y-1">
                @foreach($items as $key => $item)
              <li>
                <x-aki.tabmobilelink url="{{ Arr::get($item, 1, '') }}" :active="$active == $key">{{ $item[0] }}</x-aki.tabmobilelink>
               
              </li>
                @endforeach
              
            </ul>
          </nav>
          
    </div>
    <div class="hidden md:block tw-hidden md:tw-block">
      <div class="border-b border-gray-200 tw-border-b tw-border-gray-200">
        <nav class="flex -mb-px space-x-4 tw-flextw--mb-px tw-space-x-4" aria-label="Tabs">

          
            @foreach($items as $key => $item)
        
              <x-aki.tablink url="{{ Arr::get($item, 1, '') }}" :active="$active == $key">{{ $item[0] }}</x-aki.tablink>
             
        
              @endforeach

    
         
        
        </nav>
      </div>
    </div>
  </div>
  
</div>

@endif
