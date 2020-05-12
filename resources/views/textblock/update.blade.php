@extends('cms.layout')

@section('pagetitle')
{{ $text->name }}
@endsection

@section('head')
<?

akiredactor('css');

?>
@endsection

@section('content')

<h1>{{ $text->name }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('textblocks.update', [$text->id])]);

$ar->fill($text);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

$ar->build('text', 'Heading:', 'heading');

if($text->format == 'html'){

	$ar->build('textarea', '', 'textblock', ['class' => 'redactor']);

}else{

	$ar->build('textarea', '', 'textblock');


}

$ar->build('submit', 'Save');

$ar->close();

?>

@endsection

@section('scripts')

<?

akiredactor('js');

akiredactor('.redactor');

?>

@endsection