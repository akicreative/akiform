@props([

    'href' => '#'

])


@if($href != '#' && $href != '')

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-red-700 hover:underline hover:text-black']) }}>

@else

<div {{ $attributes->merge(['class' => 'text-red-700 hover:underline hover:text-black']) }}>

@endif



{{ $slot }}


@if($href != '#' && $href != '')

</a>

@else

</div>

@endif