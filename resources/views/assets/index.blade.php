@extends('cms.layout')

@section('pagetitle')
Assets
@endsection

@section('content')
<div class="container-fluid">

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

@if(count($rows) == 0)

<h5>There are currently no assets uploaded.</h5>

@else

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => url()->current(), 'files' => true]);


?>

<table class="table table-striped table-bordered table-sm">

<tr><th></th><th class="text-center">Key</th><th>Name</th><th></th><th class="text-center" style="width: 150px;"><button type="submit" name="savebutton" value="order" class="btn btn-sm btn-primary btn-block">Order</button></th></tr>

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

		<td class="text-center" style="font-size: 2rem; font-weight: bold;">{{ $row->id }}</td>

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

			@if($row->type() == 'image' || $row->type() == 'gif')

				<img src="{{ akiasseturl($row->id, 'tn', true) }}" class="img-fluid" style="max-height: 200px;">

			@else

				<ul class="list-unstyled mb-0">

					<li>{{ $row->filename }}</li>

					<li>

				<a href="{{ akiasseturl($row->id, '', true) }}" class="btn btn-sm btn-outline-secondary">Download File</a>		</li>

			</ul>

			@endif

		</td>

		<td>

			<?

			$ar->build('text', 'Order By:', 'orderby[' . $row->id . ']', ['fieldonly' => true, 'inline' => true, 'default' => $row->orderby]);

			?>

		</td>

	</tr>


@endforeach

</table>

{{ $rows->links() }}

<?

$ar->close();

?>

@endif

</div>

@endsection