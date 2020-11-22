@extends('cms.layout')

@section('pagetitle')
Info Lists
@endsection

@section('content')

@if($filters['category'] == '')
<h1 class="pageh1">Info Lists</h1>

<p>Please select a category on the left. Need a new category? Let Steven know.</p>

@else

<h1 class="pageh1">{{ $categories["$filters[category]"] }}</h1>

<p>The appearance of the actual content may look different on the page it is placed depending on styles.</p>

@if(count($rows) > 0)

	<? $itemnumber = 1; ?>

	@foreach($rows as $row)

		<?

		$rowclass = '';
		$fa = 'ACTIVE';

		if(!$row->active){

			$rowclass = 'bg-light';
			$fa = '<span class="text-muted">INACTIVE</span>';
		}

		?>

		<div class="row {{ $rowclass }} pt-2">

			<div class="col-1 text-center">

			

				<h2 class="mb-0 pb-0">{{ $itemnumber }}</h2>

					{!! $fa !!}

			</div>

			<div class="col-5">

				<?

				if($row->imageabove_id > 0){

					echo '<img src="' . akiasseturl($row->imageabove_id, 'tn') . '" class="img-fluid mb-3">';

				}

				?>

				<h4>

					@if(in_array($row->infotype, ['textlink', 'htmltext', 'plaintext']) && $row->url != '')

						<a href="{{ $row->url }}" {{ ($row->newwindow ? 'target="_blank"' : '') }}>

					@elseif($row->infotype == 'textfile' && $row->file_id > 0)

						<a href="{{ akiasseturl($row->file_id) }}" {{ ($row->newwindow ? 'target="_blank"' : '') }}>

					@endif

					{{ $row->title }}

					@if(in_array($row->infotype, ['textlink', 'htmltext', 'plaintext']) && $row->url != '')

						</a>

					@elseif($row->infotype == 'textfile' && $row->file_id > 0)

						</a>

					@endif


				</h4>

				@if($row->description != '')

					@if($row->infotype == 'htmltext')

						{!! $row->description !!}

					@else

						{{ $row->description }}

					@endif

				@endif

				<?

				if($row->imagebelow_id > 0){

					echo '<img src="' . akiasseturl($row->imagebelow_id, 'tn') . '" class="img-fluid mb-3">';

				}

				?>

				@if($row->spaceafter)

				<i class="fal fa-arrows-v"></i> SPACER

				@endif

				@if($row->dividerafter)

				<hr>

				@endif

			</div>

			<div class="col-md-6">

				<div class="card p-2 mb-2">

				<div class="row">

					<div class="col-md-6">

				<ul class="list-unstyled">

					<li>{{ $itemnumber }}: {{ $types["$row->infotype"] }}</li>
					<li><a href="{{ route('aki.lists.edit', [$row->id]) }}">EDIT</a></li>

				</ul>

					</div>

					<div class="col-md-6">

				<?

				$ar = new AkiForm($errors, ['inlinelist' => true]);


				$ar->open(['action' => route('aki.lists.orderby')]);

				$newposition = $position;

				unset($newposition["$row->id"]);

				if($itemnumber == 1){

					unset($newposition['top']);
				}

				$ar->build('select', 'Position', 'position', ['fieldonly' => true, 'selectoptions' => $newposition]);


				$ar->hidden('category', $filters['category']);

				$ar->hidden('moveitem', $row->id);

				$ar->build('submit', 'Move', '', ['fieldonly' => true]);

				$ar->close();

		?>

			</div>

		</div>

		</div>

			</div>

		</div>

		<? $itemnumber++; ?>

	@endforeach

@endif

@endif

@endsection