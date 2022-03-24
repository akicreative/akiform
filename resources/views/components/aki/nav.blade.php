@props([

    'items' => []

])

<div>
  
    <div class="hidden sm:block">
        
      <div class="border-b border-gray-200">
        <nav class="flex -mb-px space-x-8" aria-label="Tabs">
          <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->

            @foreach($items as $item)

                @if($item[2] != 'active')

                

          <a href="{{ $item[1] }}" class="px-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap hover:no-underline"> {{ $item[0] }} </a>

                @else

                <a href="{{ $item[1] }}" class="px-1 py-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-500 whitespace-nowrap hover:no-underline" aria-current="page"> {{ $item[0] }} </a>

                @endif

            @endforeach
  
    
        </nav>
      </div>
    </div>
  </div>