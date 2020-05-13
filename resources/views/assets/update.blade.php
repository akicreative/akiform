@extends('cms.layout')

@section('pagetitle')
Edit
@endsection

@section('content')

<div class="row">

	<div class="col-12 col-md-7">

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->fill($asset);

$ar->open(['action' => route('aki.asset.store', [$asset->id]), 'files' => true]);

$ar->build('text', 'Name/Caption:', 'name');

$ar->build('file', 'Replace File:', 'file', []);

$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

$ar->build('textarea', 'Description:', 'description');

$ar->build('submit', 'Save');

$ar->close();

?>

@if($cat->description != '')

<div class="card mt-3">

	<div class="card-body">

		{{ $cat->description }}

	</div>

</div>

@endif

	</div>

	<div class="col-12 col-md-5">



		@if($asset->type() == 'image')

			<h5>Thumbnail</h5>

			<img src="{{ asset('storage/' . $asset->serverfilenametn) }}" class="img-fluid mb-3">

		@else

			<h5>File</h5>

			<a href="{{ asset('storage/' . $asset->serverfilename) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Download File</a>


		@endif

		

	</div>


</div>

@if($asset->type() == 'image')
	
	<h5>Full Size</h5>


			<img src="{{ asset('storage/' . $asset->serverfilename) }}" class="img-fluid mb-5">

		@endif

<div class="card mt-5">

			<div class="card-body">

				<?

				$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

				$ar->open(['action' => route('aki.asset.destroy', [$asset->id]), 'files' => true]);


				$ar->build('submit', 'Delete', '', ['fieldonly' => true, 'inline' => true, 'class' => 'btn-danger']);

				$ar->close();

?>

			</div>

		</div>


@endsection