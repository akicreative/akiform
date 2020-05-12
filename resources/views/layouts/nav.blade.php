<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/cms">{{ env('APP_NAME') }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    	@includeIf('cms.nav')

    	@isset($akinavs)

    		@foreach($akinavs as $akinav)

    			{!! $akinav !!}


    		@endforeach


    	@endisset


    	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         MORE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('textblocks.index') }}">Text Blocks</a>
        </div>
      </li>


      <? /*
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
     */ ?>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="{{ route('logout') }}">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">LOGOUT</button>
    </form>
  </div>
</nav>