@props([

	'template' => 'primary',
	'href' => '#',
	'size' => 'base'

])

<?

$xpadding = 'px-4';

switch($size){

    case "slim": 
        $ypadding = 'py-1';
        $xpadding = 'px-2';
        break;
    case "sm": 
        $ypadding = 'py-1';
        break;
    default:
        $ypadding = 'py-2';
        break;

}

?>

@if($template == 'create')

<a href="{{ $href }}" {{ $attributes }} class="{{ $xpadding }} {{ $ypadding }} inline-flex items-center border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">{{ $slot }}</a>

@else

<a href="{{ $href }}" {{ $attributes }} class="{{ $xpadding }} {{ $ypadding }} inline-flex items-center border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ $slot }}</a>


@endif