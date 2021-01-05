<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">

  <div class="container-fluid">

  <a class="navbar-brand" href="{{ $akisubnavurl ?? '' }}">{{ $akisubnavtitle ?? '' }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    	@isset($akisubnav)

    		@foreach($akisubnav as $akinav)

    			{!! $akinav !!}


    		@endforeach


    	@endisset

  
    </ul>

        @isset($akisubnavform)

          {!! $akisubnavform !!}

      @endisset
   
  </div>

</div>
</nav>