@extends('cms.layout')

@section('pagetitle')
Text Blocks
@endsection

@section('content')

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th></th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<a href="{{ route('textblocks.update') }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			{{ $row->name }}

		</td>

	</tr>


@endforeach

</table>

@endsection