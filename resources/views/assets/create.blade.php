@extends('cms.layout')

@section('pagetitle')
Create Asset
@endsection

@section('content')

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.asset.store'), 'files' => true]);

$ar->build('text', 'Name/Caption:', 'name');

$ar->build('file', 'Upload File:', 'file', []);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

$ar->build('textarea', 'Description:', 'description');

$ar->build('submit', 'Create');

$ar->close();

?>

@endsection