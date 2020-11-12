@extends('cms.layout')

@section('pagetitle')
{{ $page->name }}
@endsection

@section('head')
<?

akiredactorxcss();

?>
@endsection

@section('content')

<h1>{{ $page->pagetitle }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => route('aki.page.update', [$page->id])]);


$ar->fill($page);

$ar->build('text', 'Page Title:', 'pagetitle');

$ar->build('textarea', 'Meta Description:', 'metadescription');

$ar->build('textarea', 'Meta Keywords:', 'metakeywords');

$ar->build('textarea', 'Body', 'body', ['class' => 'redactor']);

$ar->build('submit', 'Save');

$ar->close();

?>

@endsection

@section('scripts')

<?

akiredactorxjs(akiredactorxplugins(), ['upload' => 'upload']);

?>

@endsection