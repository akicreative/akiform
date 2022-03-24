@props([

	'name' => '',
	'id' => '',
	'class' => 'w-full',
	'currency' => 'USD'

])

@aware([
	'for' => '',
	'display' => ''
])

<? $attributes = $attributes->merge(['class' => 'focus:ring-indigo-500 focus:border-indigo-500 block pl-7 pr-12 sm:text-sm border-gray-300 rounded-md' . ' ' . $class]); ?>

@if($id == '' && $for != '')

	<? $id = $for; ?>

@endif

  <div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <span class="text-gray-500 sm:text-sm"> $ </span>
    </div>
    <input type="text" name="{{ $name }}" id="{{ $id }}" {{ $attributes }}>
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
      <span class="text-gray-500 sm:text-sm" id="price-currency"> {{ $currency }} </span>
    </div>
</div>
