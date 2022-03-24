@props(['id' => null, 'maxWidth' => null])

<x-tw.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 pt-4 pb-4">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div class="mt-2 border-t-2">

            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-3 text-right bg-gray-100">
        {{ $footer }}
    </div>
</x-tw.modal>