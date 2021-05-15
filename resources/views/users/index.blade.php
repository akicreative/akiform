@extends('cms.layout')

@section('pagetitle')
Users
@endsection

@section('content')

<div class="container-fluid">

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th>Users</th><th></th><th></th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<a href="{{ route('aki.users.edit', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			{{ $row->name }}

		</td>

		<td>

			{{ $row->email }}

		</td>

		<td class="text-center">

			ID: {{ $row->id }}

		</td>

	</tr>


@endforeach

</table>

</div>

@endsection