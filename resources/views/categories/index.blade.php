@extends('cms.layout')

@section('pagetitle')
Categories
@endsection

@section('content')

<h1>Categories</h1>

<ul class="list-inline">
<li class="list-inline-item"><a href="{{ route('aki.asset.index') }}">Assets</a></li>
</ul>


@if(isset($akisubnavurl))

@include('akiforms::layouts.subnav')

@endif

<div class="container-fluid">

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th>Slug</th><th>Name</th><th>Type</th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<a href="{{ route('aki.categories.edit', [$row->id]) }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			{{ $row->slug }}

		</td>

		<td>

			{{ $row->name }}

		</td>

		<td>

			{{ strtoupper($row->cattype) }}

		</td>

	</tr>


@endforeach

</table>

</div>

@endsection