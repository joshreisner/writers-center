@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>{{ $title }}</h1>
	</div>
	<div class="row">
	@foreach ($publications as $publication)
		<div class="publication col-md-6">
			<div class="inner" style="background-image:url({{ $publication->image->url }});">
				<a href="/publications/{{ $publication->slug }}">
					<div>
						{{ $publication->title }}<br>
						&ndash;<br>
						${{ $publication->price}}
					</div>
				</a>
			</div>
		</div>
	@endforeach
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
						{{ Form::chkbox('types', $type->id) }}
						{{ $type->title }}
					</label>
				</div>
				@endforeach
			</div>
		</div>
	</form>
@endsection