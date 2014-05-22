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
	<form class="switchboard form-horizontal">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
		<div class="form-group">
			<label for="types" class="col-md-3">Types</label>
			<div class="col-md-9">
				@foreach ($types as $type)
				<div class="checkbox">
					<label>
						<input type="checkbox" value="{{ $type->id }}">
						{{ $type->title }}
					</label>
				</div>
				@endforeach
			</div>
		</div>
	</form>
@endsection