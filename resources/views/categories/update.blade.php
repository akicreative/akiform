@extends('cms.layout')

@section('pagetitle')
Update Category
@endsection

@section('content')

<h1>{{ $item->name }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.categories.save', $item->id)]);

$ar->fill($item);

$ar->build('text', 'Name:', 'name', ['blockhelp' => 'Internal Name']);

$ar->build('text', 'Slug:', 'slug', ['blockhelp' => 'This must be unique.']);

$ar->build('select', 'Category:', 'category', ['selectoptions' => ['asset' => 'Assets', 'textblock' => 'Text Blocks', 'other' => 'Other']]);

$ar->build('select', 'Hidden:', 'hidden', ['selectshortcut' => 'noyes']);

$ar->build('select', 'Private:', 'private', ['selectshortcut' => 'noyes']);

$ar->build('digit', 'Full Size Width:', 'assetw');

$ar->build('digit', 'Full Size Height:', 'asseth');

$ar->build('select', 'Thumbnail Type:', 'assettnresize', ['selectoptions' => ['resize' => 'Resize', 'fit' => 'Fit']]);

$ar->build('digit', 'Thumbnail Width:', 'assettnw');

$ar->build('digit', 'Thumbnail Height:', 'assettnh');


$ar->build('submit', 'Save');

$ar->close();

?>

@endsection