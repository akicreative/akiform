@props([

    'class' => 'bg-white divide-y divide-gray-200',

])

<tbody class="{{ $class }}">
    {{ $slot }}
</tbody>