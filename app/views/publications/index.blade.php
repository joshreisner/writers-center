@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>{{ $title }}</h1>
		<ul>
		@foreach ($publications as $publication)
			<li><a href="/publications/{{ $publication->slug }}">{{ $publication->title }}</a></li>
		@endforeach
		</ul>
	</div>

@endsection

@section('side')
	<form class="switchboard">
		<div class="form-group">
			<label for="types">Types</label>
			@foreach ($types as $type)
			<div class="checkbox">
				<label>
					<input type="checkbox" value="{{ $type->id }}">
					{{ $type->title }}
				</label>
			</div>
			@endforeach
		</div>
	</form>
@endsection