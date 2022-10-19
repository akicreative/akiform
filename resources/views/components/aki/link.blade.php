@props([

    'href' => '#'

])

<?

$attributes->merge(['class' => 'text-red-700 hover:underline hover:text-black']);

?>

@if($href == '#' || $href == '')

<a href="{{ $href }}" {{ $attributes }}>

@endif

{{ $slot }}


@if($href == '#' || $href == '')

</a>
@endif