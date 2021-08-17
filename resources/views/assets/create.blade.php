@extends('cms.layout')

@section('pagetitle')
Create Asset
@endsection

@section('content')

<div class="container">

@if($focus != 'none')

<h1>{{ $category->name }}</h1>



<? $action = route('aki.asset.category.store', [$focus]); ?>

@else

<h1>Add Asset</h1>

<ul class="list-inline">
<li class="list-inline-item"><a href="{{ route('aki.asset.index') }}">Back to Assets</a></li>
</ul>

<? $action = route('aki.asset.store'); ?>

@endif


<div class="row">

	<div class="col-12 col-md-8">

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => $action, 'files' => true]);

$ar->fill(['category' => session('assetcategory', 'assetgeneral')]);

$ar->build('text', 'Name/Caption:', 'name');

$ar->build('file', 'Upload File:', 'file', []);

if($focus == 'none'){

	$ar->build('select', 'Category:', 'category', ['selectoptions' => $cats]);

}else{

	$ar->build('show', 'Category:', $category->name);

	$ar->hidden('category', $category->slug);
}

$ar->build('textarea', 'Description:', 'description');

$ar->build('submit', 'Create');

$ar->close();

?>

	</div>

	<div class="col-12 col-md-4">

		@foreach($categories as $c)

			@if($c->description != '')

			<ul class="list-unstyled">

				<li><strong>{{ $c->name }}</strong></li>

				<li>{{ $c->description }}</li>

			</ul>

			<hr>

			@endif


		@endforeach


	</div>

</div>

</div>

@endsection