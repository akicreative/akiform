@extends('cms.layout')

@section('pagetitle')
Create Category
@endsection

@section('content')

<h1>Create Category</h1>

<ul class="list-inline">
<li class="list-inline-item"><a href="{{ route('aki.asset.index') }}">Assets</a></li>
</ul>


@if(isset($akisubnavurl))

@include('akiforms::layouts.subnav')

@endif

<div class="container">

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.categories.store')]);

$ar->build('text', 'Name:', 'name', ['blockhelp' => 'Internal Name']);

$ar->build('text', 'Slug:', 'slug', ['blockhelp' => 'This must be unique.']);

$ar->build('select', 'Category Type:', 'cattype', ['selectoptions' => ['asset' => 'Assets', 'textblock' => 'Text Blocks', 'list' => 'List Group']]);

$ar->build('submit', 'Create');

$ar->close();

?>

</div>

@endsection