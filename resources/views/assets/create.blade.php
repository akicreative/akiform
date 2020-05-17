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

if($focus == 'none'){

	$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

}else{

	$ar->build('show', 'Category:', $category->name);

	$ar->hidden('category', $category->slug);
}

$ar->build('textarea', 'Description:', 'description');

$ar->build('submit', 'Create');

$ar->close();

?>

@endsection