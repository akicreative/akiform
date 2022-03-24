@props([

    'comment',
    'showdetail' => false,
    'edit' => false

])

<?

if($comment->referenceid === 0){

    $showdetail = false;

}

?>

                <div x-data="{}" class="mb-4 text-sm text-gray-500 bg-white border border-gray-200 rounded-lg">
                     
                  <div class="p-4 text-gray-900 ">

                      @if($showdetail)

                      <?

                        $details = '';

                        switch($comment->category){

                          case "customer":

                            $people = \App\Models\Customer::find($comment->referenceid);

                            $details = '<a href="' . route('people.view', $people->id) . '" class="font-bold">' . implode("<br>", $people->displayname()) .'</a>';
                            break;

                        }

?>

                      <div class="flex flex-row">

                          <div class="flex basis-1/4">

                            <? echo $details; ?>

                          </div>

                          <div class="flex basis-3/4">

                         

                      @endif

                      @if($comment->html)
                          
                        {!! $comment->comments !!}

                      @else
                        
                          {{ $comment->comments }}
                        
                      @endif

                      @if($showdetail)

                           
                          </div>
                        </div>
                        
                     
                      @endif

                </div>

                  <div class="flex flex-row justify-between px-4 py-2 bg-gray-100">
                    @if($comment->user_id === 0)

<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">Status Update</span>
                    @else
          
              <span class="mt-0 font-bold text-gray-900">{{ $comment->user_name }}</span>
           
        
                    @endif
                   <div>{{ outdate($comment->created_at, 'M j, Y g:ia') }}
                    
                    <span class="text-xs"><a href="#" @click="confirm('Are you sure?') ? $wire.delete({{ $comment->id }}) : false;" class="ml-3" ><svg xmlns="http://www.w3.org/2000/svg" class="inline w-6 h-6 stroke-gray-900 hover:stroke-red-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg></a></span>
                </div>
            </div>

                </div>