@extends('cms.layout')

@section('pagetitle')
Assets
@endsection

@section('content')

<div class="mb-2">

@if($focus == 'none')

<?

$ar = new AkiForm($errors, ['inlinelist' => true, 'size' => '']);

$ar->open(['method' => 'GET']);

$ar->build('select', 'category', 'category', ['selectoptions' => $cats, 'default' => session('assetcategory', 'assetgeneral')]);

$ar->build('submit', 'GO');

$ar->hidden('go', 'filter');

$ar->close();

?>

@else

<h1>{{ $category->name }}</h1>

@endif

</div>

<?

$ar = new AkiForm($errors, ['horizontal' => true, 'constrainform' => 'col-md-8']);

$ar->open(['action' => url()->current(), 'files' => true]);


?>

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th class="text-center"><button type="submit" name="savebutton" value="order" class="btn btn-sm btn-primary btn-block">Order</button></th><th>Name</th><th></th></tr>

@foreach($rows as $row)

	<tr>

		<td>

			<?

			if($focus == 'none'){

				$url = route('aki.asset.edit', [$row->id]);

			}else{

				$url = route('aki.asset.category.edit', [$row->id, $category->slug]);
			}

			?>

			<a href="{{ $url }}" class="btn btn-sm btn-primary">EDIT</a>

		</td>

		<td>

			<?

			$ar->build('text', 'Order By:', 'orderby[' . $row->id . ']', ['fieldonly' => true, 'inline' => true, 'default' => $row->orderby]);

			?>

		</td>

		<td>

			<ul class="list-unstyled">

				<li>

			<strong>{{ $row->name }}</strong>

		</li>

		@if($row->description)

		<li>

			{{ $row->description }}

		</li>

		@endif

	</ul>

		</td>

		<td class="text-center" style="width: 30%;">

			@if($row->type() == 'image')

				<img src="{{ asset('storage/' . $row->serverfilenametn) }}" class="img-fluid">

			@else

				<a href="{{ asset('storage/' . $row->serverfilename) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Download File</a>

			@endif

		</td>

	</tr>


@endforeach

</table>

{{ $rows->links() }}

<?

$ar->close();

?>

@endsection