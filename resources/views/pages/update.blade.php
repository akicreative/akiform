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

@if(isset($akisubnavurl))

@include('akiforms::layouts.subnav')

@endif

<div class="container">

<h1>{{ $page->pagetitle }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => route('aki.page.update', [$page->id])]);


$ar->fill($page);

$ar->build('text', 'Page Title:', 'pagetitle');

$ar->build('textarea', 'Meta Description:', 'metadescription');

$ar->build('textarea', 'Meta Keywords:', 'metakeywords');

$ar->build('textarea', 'Body', 'body', ['class' => 'redactor']);

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