<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>@yield('pagetitle')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    
    <!-- Fonts -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/f067031dde.js"></script>

    <!-- Styles -->
    
    @yield('mastercss')

    @yield('head')

</head>
<body>
    
    @yield('master')
       
   <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

@if(session()->has('pagemessage'))

<div id="pagemessagediv" class="alert alert-danger alert-dismissible fade show" style="position: fixed; top: 5px; left: 50%; transform: translate(-50%, 0);" role="alert">
  <i class="fas fa-exclamation fa-lg"></i>  {!! session('pagemessage') !!}
</div>

<script type="text/javascript">

function hidepagemessagediv()
{

    $('#pagemessagediv').alert('close');
}

(function(){
    
    setTimeout(hidepagemessagediv, 10000);

})();
    
    

</script>

@endif



    @yield('masterscripts')

    @yield('scripts')



</body>
</html>