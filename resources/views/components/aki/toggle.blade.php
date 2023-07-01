@props([

    'field' => '',
    'active' => false

])

<div class="flex space-x-2">
    
    <button type="button" wire:click="$toggle('{{ $field }}')" @class([
        "relative",
        "inline-flex",
        "flex-shrink-0",
        "h-6",
        "transition-colors",
        "duration-200",
        "ease-in-out",
        "bg-gray-200" => !$active,
        "bg-blue-500" => $active,
        "border-2",
        "border-transparent",
        "rounded-full",
        "cursor-pointer",
        "w-11",
        "focus:outline-none",
        "focus:ring-2",
        "focus:ring-indigo-600",
        "focus:ring-offset-2"
        ])
        
        role="switch" aria-checked="false">
    <span class="sr-only"></span>
    <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
    <span aria-hidden="true" @class([
        "inline-block",
        "w-5",
        "h-5",
        "transition",
        "duration-200",
        "ease-in-out",
        "transform",
        "translate-x-0" => !$active,
        "translate-x-5" => $active,
        "bg-white",
        "rounded-full",
        "shadow",
        "pointer-events-none",
        "ring-0"
    ])>
    </span>
    </button>
    <div>
        {{ $slot }}
    </div>

</div>