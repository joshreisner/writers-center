@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<div class="post">
			<h1>
				<small>{{ $post->publish_date->format(Config::get('config.date_format')) }}</small>
				{{ $post->title }}
				{{ BlogController::editLink($post) }}
			</h1>
			<div class="content">{{ $post->content }}</div>
		</div>
	</div>

@endsection

@section('side')
	<div class="wallpaper">
	</div>
@endsection