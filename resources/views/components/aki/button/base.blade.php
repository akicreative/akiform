@aware([

    'size' => 'base',
    'href' => '',
    'confirm' => '',
    'method' => ''

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


        /* inline-flex rounded-md shadow-sm */
?>

@if($href == '')

<span class="">

    @if($confirm == '')

    <button
        {{ $attributes->merge([
            'type' => 'button',
            'class' => $ypadding .  ' ' . $xpadding . ' border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
        ]) }}

    

    >
        {{ $slot }}
    </button>

    @else

    <button
    {{ $attributes->whereDoesntStartWith('wire:model')->merge([
        'type' => 'button',
        'class' => $ypadding .  ' ' . $xpadding . ' border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}

        @click="confirm('{{ $confirm }}') ? $wire.{{ $method }} : false;"

>
    {{ $slot }}
</button>


    @endif

</span>

@else

<a href="{!! $href !!}" 
{{ $attributes->merge([
    'class' => $ypadding .  ' ' . $xpadding . ' border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out hover:no-underline' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
]) }}
>
{{ $slot }}
</a>

@endif