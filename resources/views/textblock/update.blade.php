@extends('cms.layout')

@section('pagetitle')
{{ $text->name }}
@endsection

@section('head')
<?

akiredactorxcss();

?>
@endsection

@section('content')


<div class="container">

<h1>{{ $text->name }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => route('aki.textblock.update', [$text->id])]);


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

</div>

@endsection

@section('scripts')

<?

akiredactorxjs(akiredactorxplugins(), ['upload' => 'upload']);


?>



@endsection