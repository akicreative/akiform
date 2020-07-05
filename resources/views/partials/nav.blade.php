<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  @isset($akinavbrand)

    @isset($akinavbrandurl)

      <a class="navbar-brand" href="{{ $akinavbrandurl }}">

    @endisset

      {{ $akinavbrand }}

    @isset($akinavbrandurl)

      </a>

    @endisset

  @endisset

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#akisubpagenav" aria-controls="akisubpagenav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="akisubpagenav">
    <ul class="navbar-nav mr-auto">

    	@isset($akinavitems)

    		@foreach($akinavitems as $akinavitem)

    			{!! $akinavitem !!}


    		@endforeach


    	@endisset

  
    </ul>

        @isset($akinavform)

          {!! $akinavform !!}

      @endisset
   
  </div>
</nav>