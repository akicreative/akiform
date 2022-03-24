@props([

    'class' => ''

])


<?

$attributes = $attributes->merge(['class' => 'relative' . ' ' . $class]); 

?>

<!-- This example requires Tailwind CSS v2.0+ -->
<div {{ $attributes }}>
  <div class="absolute inset-0 flex items-center" aria-hidden="true">
    <div class="w-full border-t border-blue-300"></div>
  </div>
  <div class="relative flex justify-center">
    <span class="px-3 bg-white text-lg font-medium text-blue-900"> {{ $slot }} </span>
  </div>
</div>