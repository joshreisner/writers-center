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
	<form class="switchboard">
		<div class="form-group">
			<label for="genre">Show</label>
			<select name="genre" id="genre" class="form-control">
				<option selected="selected">Most Recent Posts</option>
				@foreach ($years as $year)
				<option value="{{ $year }}">{{ $year }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="tags">Tags</label>
			@foreach ($tags as $tag)
			<div class="checkbox">
				<label>
					<input type="checkbox" value="{{ $tag->id }}">
					{{ $tag->title }}
				</label>
			</div>
			@endforeach
		</div>
	</form>
@endsection