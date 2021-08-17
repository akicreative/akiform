@extends('cms.layout')

@section('pagetitle')
Text Blocks
@endsection

@section('content')

<div class="container-fluid">


<h1>Assets</h1>

<div class="card mb-3">

	<div class="card-body">

	<?

$ar = new AkiForm($errors, ['inlinelist' => true, 'size' => '']);

$ar->open(['method' => 'GET']);

$ar->build('select', 'category', 'category', ['selectoptions' => ['all' => 'All Categories'] + $cats, 'default' => session('textblockcategory', 'textblockgeneral')]);

$ar->build('submit', 'GO');

$ar->hidden('go', 'filter');

echo '<li class="list-inline-item">';

echo ' <a href="' . action('\AkiCreative\AkiForms\TextblockController@create') . '" class="btn btn-success btn-sm my-2 my-sm-0">ADD</a>';

echo '</li>';

echo '<li class="list-inline-item">';

echo '<a class="nav-link" href="' . route('aki.categories.index') . '">Category Management</a>';

echo '</li>';


$ar->close();

?>		

	</div>

	</div>

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th>Category</th><th>Name</th><th></th></tr>

@foreach($rows as $row)

	<?

	$cat = $row->category;

	?>

	<tr>

		<td>

			<a href="{{ route('aki.textblock.edit', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			{{ $cats[$cat] }}

		</td>

		<td>

			{{ $row->name }}

		</td>

		<td class="text-center">

			ID: {{ $row->id }}

		</td>

	</tr>


@endforeach

</table>

</div>

@endsection