@extends('cms.layout')

@section('pagetitle')
Assets
@endsection

@section('content')

<div class="mb-2">

<?

$ar = new AkiForm($errors, ['inlinelist' => true, 'size' => '']);

$ar->open(['method' => 'GET']);

$ar->build('select', 'property', 'property', ['selectoptions' => $cats, 'default' => session('assetcategroy', 'assetgeneral')]);

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

			<a href="{{ route('assets.update', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

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

@endsection