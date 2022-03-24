@props([

    'name' => '',
    'value' => ''

])

<div class="mt-2 bg-white editorblock" wire:ignore>
    <div
         x-data
         x-ref="{{ $name }}"
         x-init="
           quill = new Quill($refs.{{ $name }}, {theme: 'snow'});
           quill.on('text-change', function () {
             $dispatch('input', quill.root.innerHTML);
           });
         "
         wire:model.defer="{{ $name }}"
    >
      {!! $value !!}
    </div>

   
  </div>