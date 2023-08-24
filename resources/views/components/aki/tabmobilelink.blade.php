@props([

    'active' => false,
    'url' => ''


])

@if($url == '')

    <div class="flex p-2 pl-3 text-sm font-semibold leading-6 text-indigo-600 rounded-md group gap-x-3 tw-flex tw-p-2 tw-pl-3 tw-text-sm tw-font-semibold tw-leading-6 tw-text-indigo-600 tw-rounded-md tw-group tw-gap-x-3 ">{!! $slot !!}</div>

@else

    @if($active)

    <a href="{{ $url }}" class="flex p-2 pl-3 text-sm font-semibold leading-6 text-indigo-600 bg-gray-100 rounded-md group gap-x-3 hover:no-underline tw-flex tw-p-2 tw-pl-3 tw-text-sm tw-font-semibold tw-leading-6 tw-text-indigo-600 tw-bg-gray-100 tw-rounded-md tw-group tw-gap-x-3 hover:tw-no-underline ">{!! $slot !!}</a>

    @else

    <a href="{{ $url }}" class="flex p-2 pl-3 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-indigo-600 hover:bg-gray-100 group gap-x-3 hover:no-underline tw-flex tw-p-2 tw-pl-3 tw-text-sm tw-font-semibold tw-leading-6 tw-text-gray-700 tw-rounded-md hover:tw-text-indigo-600 hover:tw-bg-gray-100 tw-group tw-gap-x-3 hover:tw-no-underline">{!! $slot !!}</a>

    @endif

@endif