@props([

    'label' => '',
    'labelclass' => 'font-bold fw-bold',
    'top' => 'py-1',
    'blankempty' => false,
    'size' => '',
    'hover' => false

])

@if($blankempty && $slot == '')

@else

<?

$default = true;
$w50 = false;
$w30 = false;

if($size == '50p'){

    $w50 = true;
    $default = false;

}elseif($size == '30p'){

    $w30 = true;
    $default = false;

}

if($hover){

    $top .= ' hover:bg-gray-100 px-2';
}

?>

<div class="sm:flex sm:flex-row {{ $top }}">
    <div 
        @class([
    
            $labelclass,
            'sm:basis-2/5' => $default,
            'md:basis-1/5' => $default,
            'sm:basis-1/2' => $w50,
            'md:basis-1/2' => $w50,
            'sm:basis-2/5' => $w30,
            'md:basis-2/5' => $w30,

        ])
    >
        {{ $label }}
    </div>
    <div 
        @class([
          
            'sm:basis-3/5' => $default,
            'md:basis-4/5' => $default,
            'sm:basis-1/2' => $w50,
            'md:basis-1/2' => $w50,
            'sm:basis-3/5' => $w30,
            'md:basis-3/5' => $w30,

        ])    
    >
        {{ $slot }}
    </div>

</div>

@endif