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

$ar->build('select', 'Category:', 'category', ['selectoptions' => ['asset' => 'Assets', 'textblock' => 'Text Blocks', 'other' => 'Other']]);

$ar->build('submit', 'Create');

$ar->close();

?>

@endsection