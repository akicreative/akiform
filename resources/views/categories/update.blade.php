@extends('cms.layout')

@section('pagetitle')
Update Category
@endsection

@section('content')

@if(isset($akisubnavurl))

@include('akiforms::layouts.subnav')

@endif

<div class="container">

<h1>{{ $item->name }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.categories.update', $item->id)]);

$ar->fill($item);

$ar->build('text', 'Name:', 'name', ['blockhelp' => 'Internal Name']);

$ar->build('text', 'Slug:', 'slug', ['blockhelp' => 'This must be unique.']);

if($item->cattype != 'list'){

	$ar->build('select', 'Hidden:', 'hidden', ['selectshortcut' => 'noyes']);

	$ar->build('select', 'Private:', 'private', ['selectshortcut' => 'noyes']);

	$ar->build('number', 'Full Size Width:', 'assetw');

	$ar->build('number', 'Full Size Height:', 'asseth');

	$ar->build('select', 'Thumbnail Type:', 'assettnresize', ['selectoptions' => ['resize' => 'Resize', 'fit' => 'Fit']]);

	$ar->build('number', 'Thumbnail Width:', 'assettnw');

	$ar->build('number', 'Thumbnail Height:', 'assettnh');

}


$ar->build('submit', 'Save');

$ar->close();

?>

</div>

@endsection