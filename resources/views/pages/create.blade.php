@extends('cms.layout')

@section('pagetitle')
Create Page
@endsection

@section('content')

@if(isset($akisubnavurl))

@include('akiforms::layouts.subnav')

@endif

<div class="container">

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.page.store')]);

$ar->build('text', 'Page Title:', 'pagetitle');

$ar->build('submit', 'Create');

$ar->close();

?>

</div>

@endsection