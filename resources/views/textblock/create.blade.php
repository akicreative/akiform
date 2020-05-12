@extends('cms.layout')

@section('pagetitle')
Create Text Block
@endsection

@section('content')

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('textblocks.store')]);

$ar->build('text', 'Name:', 'name', ['blockhelp' => 'Internal Name']);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

$ar->build('select', 'Format:', 'format', ['selectoptions' => ['html' => 'HTML', 'text' => 'Plain Text']]);

$ar->build('submit', 'Create');

$ar->close();

?>

@endsection