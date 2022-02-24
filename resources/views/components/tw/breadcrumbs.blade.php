@props([

  'breadcrumbs' => []

])

@if(count($breadcrumbs) > 0)

          <!-- This example requires Tailwind CSS v2.0+ -->
          <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol role="list" class="bg-white rounded-md shadow-sm px-6 flex space-x-4">
           
              <? $firstbc = true; ?>

              @foreach($breadcrumbs as $bc)

              <li class="flex">
                <div class="flex items-center">
                  @if(!$firstbc)
                 <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                  @endif

                  <?

                  $linktype = '';

                  if(array_key_exists(2, $bc)){

                      $linktype = $bc[2];

                  }

                  ?>

                  @if(array_key_exists(1, $bc) && $linktype == 'button')

                    <button {!! $bc[1] !!} type="button" class="text-indigo-400 hover:text-gray-500 py-2 {{ ($firstbc ? '' : 'ml-4') }}">{{ $bc[0] }}</button>

                  @elseif(array_key_exists(1, $bc) && $linktype != 'button')

                  <a href="{{ $bc[1] }}" class="text-indigo-400 hover:text-gray-500 py-2 {{ ($firstbc ? '' : 'ml-4') }}">{{ $bc[0] }}</a>

                  @else

                  <span class="text-gray-400 py-2 {{ ($firstbc ? '' : 'ml-4') }}">{{ $bc[0] }}</span>
                  
                  @endif


                </div>
              </li>

                <? $firstbc = false; ?>

              @endforeach

              
            </ol>
          </nav>

@endif