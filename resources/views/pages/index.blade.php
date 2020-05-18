@extends('cms.layout')

@section('pagetitle')
Pages
@endsection

@section('content')

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th>Page Title</th><th></th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<a href="{{ route('aki.page.edit', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			{{ $row->pagetitle }}

		</td>

		<td class="text-center">

			ID: {{ $row->id }}

		</td>

	</tr>


@endforeach

</table>

@endsection