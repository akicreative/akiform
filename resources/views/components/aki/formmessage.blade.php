@props([

    'formmessage' => 'formmessage'

])

@aware([

    'formmessage'

])

@if(session()->has($formmessage))

    <div class="p-2 mb-2 font-bold text-center text-orange-600 bg-orange-200 border border-orange-500 rounded-lg shadow-sm">

        {{ session($formmessage) }}

    </div>

@endif