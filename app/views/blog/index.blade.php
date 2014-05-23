@extends('page')

@section('content')
	<div class="col-md-offset-1">
		@foreach ($posts as $post)
		<div class="post">
			<div class="date">
				{{ $post->publish_date->format(Config::get('config.date_format')) }}
				{{ BlogController::editLink($post) }}
			</div>
			<h2><a href="/blog/{{ $post->slug }}">{{ $post->title }}</a></h2>
			<div class="content">{{ $post->content }}</div>
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
			<label for="genre" class="col-md-3">Show</label>
			<div class="col-md-9">
				{{ Form::dropdown('year', $years) }}
			</div>
		</div>
		<div class="form-group">
			<label for="tags" class="col-md-3">Tags</label>
			<div class="col-md-9">
				@foreach ($tags as $tag)
				<div class="checkbox">
					<label>
						{{ Form::chkbox('tag', $tag->id) }}
						{{ $tag->title }}
					</label>
				</div>
				@endforeach
			</div>
		</div>
	</form>
@endsection