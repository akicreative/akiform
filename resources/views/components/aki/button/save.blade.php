<x-aki.button.base {{ $attributes->merge(['class' => 'text-white bg-green-600 hover:bg-green-500 active:bg-green-700 border-green-600']) }} wire:loading.attr='disabled'>{{ $slot }}</x-aki.button.base>