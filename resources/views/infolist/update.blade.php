@extends('cms.layout')

@section('pagetitle')
Edit Item
@endsection

@section('head')
<?

akiredactorxcss();

?>
@endsection

@section('content')


<div class="container">

<div class="row">

	<div class="col-md-3 mb-3">

		@include('akiforms::infolist.sidebar')

	</div>

	<div class="col-md-9">

<h1 class="pageh1">{{ $categories["$item->category"] }} - Edit Item</h1>

<h2>{{ $types["$item->infotype"] }}</h2>

<div class="row">

	<div class="col-md-8">

<?

/*

  'header' => 'Header',
'textlink' => 'Link',
'textfile' => 'File',
'htmltext' => 'HTML Text',
'plaintext' => 'Plain Text',

            */

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => route('aki.lists.save', [$item->id]), 'files' => true], $item);

$ar->build('select', 'Status:', 'active', ['selectoptions' => [1 => 'Active', 0 => 'Inactive'], 'default' => 1]);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $categories]);

$ar->build('text', 'Title:', 'title');

if(in_array($item->infotype, ['textfile'])){

	$ar->build('file', 'Link to File:', 'file');

	if($item->file_id > 0){

		$ar->build('switch', 'Remove File on Save:', '', ['checkboxvalues' => [['filedelete', 'Yes, delete on save.']]]);

	}
}

if(in_array($item->infotype, ['textlink', 'htmltext', 'plaintext'])){

	$ar->build('text', 'URL:', 'url');

	$ar->build('switch', 'Open in New Tab:', '', ['checkboxvalues' => [['newwindow', 'Yes']]]);
}

if(in_array($item->infotype, ['htmltext'])){

	$ar->build('textarea', 'Text:', 'description', ['class' => 'redactor']);

}elseif(in_array($item->infotype, ['plaintext'])){

	$ar->build('textarea', 'Text:', 'description');

}

echo '<hr>';


$ar->build('file', 'Image Above:', 'imageabove');

if($item->imageabove_id > 0){

	echo '<img src="' . akiasseturl($item->imageabove_id, 'tn') . '" class="img-fluid mb-3">';

	$ar->build('switch', 'Remove Image on Save:', '', ['checkboxvalues' => [['imageabovedelete', 'Yes, delete on save.']]]);

}

echo '<hr>';

$ar->build('file', 'Image Below:', 'imagebelow');

if($item->imagebelow_id > 0){

	echo '<img src="' . akiasseturl($item->imagebelow_id, 'tn') . '" class="img-fluid mb-3">';

	$ar->build('switch', 'Remove Image on Save:', '', ['checkboxvalues' => [['imagebelowdelete', 'Yes, delete on save.']]]);

}

echo '<hr>';

$ar->build('switch', 'More...', '', ['checkboxvalues' => [['spaceafter', 'Add Space After'], ['dividerafter', 'Add Divider After']]]);


$ar->build('submit', 'Save Entry');

$ar->close();


?>

	</div>

	<div class="col-md-4">

		<div class="card border-danger">

			<div class="card-body">

<?

$ar = new AkiForm($errors);

$ar->open(['action' => route('aki.lists.destroy', [$item->id]), 'files' => true], $item);

$ar->build('select', 'Confirm Delete:', 'confirm', ['selectoptions' => ['N' => '...', 'Y' => 'Yes, delete this entry.']]);

$ar->build('submit', 'DELETE');

$ar->close();

?>
	</div>

	</div>

	</div>

</div>

</div>

</div>

</div>

@endsection

@section('scripts')

<?

akiredactorxjs(akiredactorxplugins());

?>

@endsection