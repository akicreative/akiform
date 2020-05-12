@extends('cms.layout')

@section('pagetitle')
Text Blocks
@endsection

@section('content')

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th>Name</th><th></th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<a href="{{ route('aki.textblock.edit', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

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