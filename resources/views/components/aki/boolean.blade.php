@props([

    'yes' => false

])

@if($yes)

<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto stroke-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
  </svg>

@else

<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto stroke-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
  </svg>

@endif