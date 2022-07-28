@props([

    'href' => '#'

])

<?

$attributes->merge(['class' => 'text-red-700 hover:underline hover:text-black']);

?>

<a href="{{ $href }}" class="text-red-700 hover:underline hover:text-black">{{ $slot }}</a>