@props(['id' => null, 'maxWidth' => null])

<x-tw.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg text-right">
           Close
        </div>

        <div class="mt-4">

            {{ $content }}
        </div>
    </div>

</x-tw.modal>