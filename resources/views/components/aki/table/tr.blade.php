@props([

    'class' => 'bg-white hover:bg-slate-100',

])

<tr class="{{ $class }}">
    {{ $slot }}
</tr>