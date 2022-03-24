@props([

  'items' => [],

])

@aware([
  'items',
  'heading',
  'display'
])


<? $bgdarker = 'bg-gray-50';  $bg = ''; ?>


  <div class="{{ ($heading != '' ? 'border-t border-gray-200' : '') }}">
    <dl>

      @foreach($items as $item)

      <? if($bg != $bgdarker) { $bg = $bgdarker; } else { $bg = 'bg-white'; } ?>

      @if($display == 'vertical')

        <div class="{{ $bg }} p-2">
          
          <dd class="mt-1 text-base text-black-900">{!! Arr::get($item, 1, '') !!}</dd>
          <dt class="text-xs font-bold text-gray-400">{!! Arr::get($item, 0, '') !!}</dt>
        </div>

      @else

        

        <div class="{{ $bg }} px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-bold text-gray-500">{!! Arr::get($item, 0, '') !!}</dt>
          <dd class="text-xs text-black-900 sm:mt-0 sm:col-span-2">{!! Arr::get($item, 1, '') !!}</dd>
        </div>

      @endif

      @endforeach
      
    </dl>
  </div>
