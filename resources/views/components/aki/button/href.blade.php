@props([

    'size' => 'base',
    'style' => 'text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 border-indigo-600', 
    'color' => ''

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

    if($color != ''){

        $style = 'text-white bg-' . $color . '-600 hover:bg-' . $color . '-500 active:bg-' . $color . '-700 border-' . $color . '-600';
    }

?>

<span class="inline-flex rounded-md shadow-sm">
    <a
        {{ $attributes->merge([
            'class' => $ypadding .  ' ' . $xpadding . ' border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out hover:no-underline ' . $style . ' ' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
        ]) }}
    >
        {{ $slot }}
        </a>
</span>