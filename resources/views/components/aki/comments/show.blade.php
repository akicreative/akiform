
@if($showform)
<form wire:submit.prevent="add" class="mt-3">

        <x-akiforms::aki.textarea wire:model.lazy="comments" name="comments"></x-akiforms::aki.textarea>

       

        <x-akiforms::aki.button type="submit" >Add Comment</x-akiforms::aki.button>

    </form>

<hr class="my-3">

@endif

@if(count($comments) > 0)

        

        @foreach($comments as $c)

                <div class="flex flex-row pb-4 mb-4 space-x-4 text-sm text-gray-500 border-b border-gray-400">
                        <div class="basis-1/4" x-data="{}">
                        @if($c->statusupdate)

<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">Status Update</span>
                        @else
              
                  <h3 class="mt-0 font-bold text-gray-900">{{ $c->user_name }}</h3>
                  <p>{{ outdate($c->created_at, 'M j, Y g:ia') }}</p>
                  <p class="text-xs"><a href="#" @click="confirm('Are you sure?') ? $wire.delete({{ $c->id }}) : false;">DELETE</a>
                
                        @endif
                </div>
                  <div class="flex-auto text-gray-900">
                    {{ $c->comments }}
                  </div>

                </div>

        @endforeach

     

@else

        <x-akiforms::aki.alert>No comments have been added yet.</x-akiforms::aki.alert>

@endif
