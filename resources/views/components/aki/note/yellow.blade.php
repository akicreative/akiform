@props([

])

@aware([

    'class'

])

<?

$attributes = $attributes->merge(['class' => 'px-4 py-2 border-l-4 border-yellow-400 bg-yellow-50']);

?>

<div {{ $attributes }}>

       
        
            <div class="text-sm font-bold text-yellow-700">
               {!! $slot !!}
            </div>
   
      
     
    
</div>