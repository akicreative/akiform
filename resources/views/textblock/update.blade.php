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

	<ul class="list-inline">
<li class="list-inline-item"><a href="{{ route('aki.textblock.index') }}">Back to Text Blocks</a></li>
</ul>


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