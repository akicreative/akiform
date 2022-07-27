@props([

    'formmessage' => 'formmessage'

])

@if(session()->has($formmessage))

    <div class="p-2 mb-2 font-bold text-center text-red-600 bg-red-100 border-1 border-red-500 rounded-lg shadow-sm">

        {!! session($formmessage) !!}

    </div>

@endif