

<div class="list-group mb-1">

	@if($filters['category'] != '')

	<div class="list-group-item">

		<?

		$ar = new AkiForm($errors);


		$ar->open(['action' => route('aki.lists.store')]);

		echo '<div class="mb-3">';

		$ar->build('select', 'Type', 'type', ['fieldonly' => true, 'selectoptions' => $types]);

		echo '</div>';

		echo '<div class="mb-3">';

		$ar->build('select', 'Position', 'position', ['fieldonly' => true, 'selectoptions' => $position]);

		echo '</div>';

		$ar->hidden('category', $filters['category']);

		$ar->build('submit', 'Create', '', ['fieldonly' => true, 'class' => 'btn btn-block btn-success']);

		$ar->close();


		?>

	</div>

	@endif


@foreach($categories as $key => $value)

	<div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><a href="{{ route('aki.lists.index', ['go' => 'filter', 'category' => $key]) }}">{{ $value }}</a></div>

@endforeach

</div>