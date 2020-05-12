@extends('cms.layout')

@section('pagetitle')
Create Text Block
@endsection

@section('content')

<?

$ar = new AkiFormTest($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open();

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

$ar->close();

?>

@endsection