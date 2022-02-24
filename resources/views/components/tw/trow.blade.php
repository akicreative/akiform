@props([

    'class' => 'bg-white divide-y divide-gray-200',

])

<tr class="{{ $class }}">
    {{ $slot }}
</tr>