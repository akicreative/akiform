@extends('cms.layout')

@section('pagetitle')
Create Category
@endsection

@section('content')

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.categories.store')]);

$ar->build('text', 'Name:', 'name', ['blockhelp' => 'Internal Name']);

$ar->build('text', 'Slug:', 'slug', ['blockhelp' => 'This must be unique.']);

$ar->build('select', 'Category Type:', 'cattype', ['selectoptions' => ['asset' => 'Assets', 'textblock' => 'Text Blocks', 'list' => 'List Group']]);

$ar->build('submit', 'Create');

$ar->close();

?>

@endsection