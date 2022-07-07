@props([

])

@aware([

    'class'

])

<?

$attributes = $attributes->merge(['class' => 'px-4 py-2 border-l-4 border-red-400 bg-red-50']);

?>

<div {{ $attributes }}>

       
        
            <div class="text-sm font-bold text-red-700">
               {!! $slot !!}
            </div>
   
    
</div>