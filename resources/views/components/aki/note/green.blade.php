@props([

])

@aware([

    'class'

])

<?

$attributes = $attributes->merge(['class' => 'px-4 py-2 border-l-4 border-green-400 bg-green-50']);

?>

<div {{ $attributes }}>

       
        
            <div class="text-sm font-bold text-green-700">
               {!! $slot !!}
            </div>
   
    
</div>