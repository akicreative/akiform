@extends('cms.layout')

@section('pagetitle')
Create Text Block
@endsection

@section('content')


<div class="container">

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => route('aki.textblock.store')]);

$fill = [

	'category' => request()->old('category', session('textblockcategory'))

];

$ar->fill($fill);

$ar->build('text', 'Name:', 'name', ['blockhelp' => 'Internal Name']);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

$ar->build('select', 'Format:', 'format', ['selectoptions' => ['html' => 'HTML', 'text' => 'Plain Text']]);

$ar->build('submit', 'Create');

$ar->close();

?>

</div>

@endsection