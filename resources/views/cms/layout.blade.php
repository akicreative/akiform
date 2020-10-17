@extends('layouts.app')

@section('master')

@include('akiforms::layouts.nav')

@if(isset($akisubnav) || isset($akisubnavform))

	@include('akiforms::layouts.subnav')

@endif

<div class="container-fluid pt-3">

	@if(session()->has('staticmessage'))

<div class="alert alert-danger alert-dismissible fade show d-print-none" role="alert">
 {!! session('staticmessage') !!}
</div>

@endif

    @yield('content')

</div>



@endsection