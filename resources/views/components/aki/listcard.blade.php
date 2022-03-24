@props([

	'items' => [],
	'heading' => '',
	'headingdetails' => ''

])

<div class="bg-white shadow-sm overflow-hidden sm:rounded-lg">

	@if($heading != '')

	 <div class="px-4 py-4 sm:px-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $heading }}</h3>
    @if($headingdetails != '')
    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $headingdetails }}</p>
  	@endif
  </div>

  @endif

	<x-tw.liststriped></x-tw.liststriped>

</div>