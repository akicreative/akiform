@extends('cms.layout')

@section('pagetitle')
Text Blocks
@endsection

@section('content')

<div class="container-fluid">

<div class="card mb-3">

	<div class="card-body">

	<?

$ar = new AkiForm($errors, ['inlinelist' => true, 'size' => '']);

$ar->open(['method' => 'GET']);

$ar->build('select', 'category', 'category', ['selectoptions' => ['all' => 'All Categories'] + $cats, 'default' => session('textblockcategory', 'textblockgeneral')]);

$ar->build('submit', 'GO');

$ar->hidden('go', 'filter');

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