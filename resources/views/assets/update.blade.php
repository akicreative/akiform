@extends('cms.layout')

@section('pagetitle')
Edit
@endsection

@section('content')

<div class="container-fluid">

@if($focus != 'none')

<h1>{{ $category->name }}</h1>



<? 

$action = route('aki.asset.category.update', [$asset->id, $focus]);

$destroyaction = route('aki.asset.category.destroy', [$asset->id, $focus]);

?>

@else

<h1>Assets</h1>

<ul class="list-inline">
<li class="list-inline-item"><a href="{{ route('aki.asset.index') }}">Back to Assets</a></li>
</ul>

<? 

$action = route('aki.asset.update', [$asset->id]);

$destroyaction = route('aki.asset.destroy', [$asset->id]);


?>

@endif


<div class="row">

	<div class="col-12 col-md-7">

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->fill($asset);

$ar->open(['action' => $action, 'files' => true]);

$ar->build('text', 'Name/Caption:', 'name');

$ar->build('file', 'Replace File:', 'file', []);

if($focus == 'none'){

	$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats, 'default' => session('assetcategory', 'assetgeneral')]);

}else{

	$ar->build('show', 'Category:', $category->name);

	$ar->hidden('category', $category->slug);
}



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

			<img src="{{ akiasseturl($asset->id, 'tn', true) }}" class="img-fluid mb-3">

			@if($asset->serverfilenamesq != '')

			<h5>Square</h5>

			<img src="{{ akiasseturl($asset->id, 'sq', true) }}" class="img-fluid mb-3">

			@endif

		@elseif($asset->type() != 'gif')

			<h5>File</h5>

			<a href="{{ akiasseturl($asset->id, '', true) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Download File</a>


		@endif

		

	</div>


</div>

@if($asset->type() == 'image' || $asset->type() == 'gif')
	
	<h5 class="mt-3">Full Size Image</h5>


			<img src="{{ akiasseturl($asset->id, 'full', true) }}" class="img-fluid mb-5">

		@endif

<div class="card mt-5">

			<div class="card-body">

				<?

				$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

				$ar->open(['action' => $destroyaction, 'files' => true]);


				$ar->build('submit', 'Delete', '', ['fieldonly' => true, 'inline' => true, 'class' => 'btn-danger']);

				$ar->close();

?>

			</div>

		</div>

</div>

@endsection