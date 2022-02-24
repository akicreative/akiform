@props([

  'items' => []

])

<ul role="list" class="divide-y divide-gray-200">

  <!-- <li class="py-4"></li> -->

  {{ $slot }}

  <!-- More items... -->
</ul>