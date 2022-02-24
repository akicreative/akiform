

<form wire:submit.prevent="add" class="mt-3">

        <x-tw.textarea wire:model.lazy="comment" name="comment"></x-tw.textarea>

        <x-tw.button type="submit" >Add Comment</x-tw.button>

    </form>

<hr class="my-3">

@if(count($comments) > 0)

        

        @foreach($comments as $c)

                <div class="flex flex-row text-sm text-gray-500 space-x-4 border-b border-gray-400 pb-4 mb-4">

                <div class="basis-1/4" x-data="{}">
                  <h3 class="font-bold text-gray-900 mt-0">{{ $c->user_name }}</h3>
                  <p>{{ outdate($c->created_at, 'M j, Y g:ia') }}</p>
                  <p class="text-xs"><a href="#" @click="confirm('Are you sure?') ? $wire.delete({{ $c->id }}) : false;">DELETE</a>
                </div>

                  <div class="flex-auto text-gray-900">
                    {{ $c->comment }}
                  </div>

                </div>

        @endforeach

     

@else

        <x-tw.alert>No comments have been added yet.</x-tw.alert>

@endif
