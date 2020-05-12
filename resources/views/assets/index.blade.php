@extends('cms.layout')

@section('pagetitle')
Assets
@endsection

@section('content')

<div class="mb-2">

<?

$ar = new AkiForm($errors, ['inlinelist' => true, 'size' => '']);

$ar->open(['method' => 'GET']);

$ar->build('select', 'category', 'category', ['selectoptions' => $cats, 'default' => session('assetcategory', 'assetgeneral')]);

$ar->build('submit', 'GO');

$ar->hidden('go', 'filter');

$ar->close();

?>

</div>

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th>Name</th><th></th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<a href="{{ route('aki.asset.update', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			{{ $row->name }}

		</td>

		<td class="text-center">

			

		</td>

	</tr>


@endforeach

</table>

@endsection