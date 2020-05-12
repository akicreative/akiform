@extends('cms.layout')

@section('pagetitle')
{{ $text->name }}
@endsection

@section('content')

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('textblocks.update')]);

$ar->fill($text);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

if($text->format == 'html'){

	$ar->build('textarea', '', 'test', ['class' => 'redactor']);

}else{

	$ar->build('textarea', '', 'test', ['class' => 'redactor']);


}

$ar->build('submit', 'Create');

$ar->close();

?>

@endsection

@section('scripts')

<?

akiredactor('js');

akiredactor('.redactor');

?>

@endsection