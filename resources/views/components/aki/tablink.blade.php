@props([

    'active' => false,
    'url' => ''


])

@if($url == '')

    <div class="inline-flex items-center px-1 py-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-500 group tw-inline-flex tw-items-center tw-px-1 tw-py-2 tw-text-sm tw-font-medium tw-text-indigo-600 tw-border-b-2 tw-border-indigo-500 tw-group">{!! $slot !!}</div>

@else

    @if($active)

    <a href="{{ $url }}" class="inline-flex items-center px-1 py-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-500 group hover:no-underline tw-inline-flex tw-items-center tw-px-1 tw-py-2 tw-text-sm tw-font-medium tw-text-indigo-600 tw-border-b-2 tw-border-indigo-500 tw-group hover:tw-no-underline ">{!! $slot !!}</a>

    @else



    <a href="{{ $url }}" class="inline-flex items-center px-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700 group hover:no-underline tw-inline-flex tw-items-center tw-px-1 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-border-gray-300 hover:tw-text-gray-700 tw-group hover:tw-no-underline">{!! $slot !!}</a>

    @endif

@endif