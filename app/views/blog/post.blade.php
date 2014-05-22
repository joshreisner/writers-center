@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<div class="post">
			<div class="date">{{ $post->publish_date->format(Config::get('config.date_format')) }}</div>
			<h1>{{ $post->title }}</h1>
			<div class="content">{{ $post->content }}</div>
		</div>
	</div>

@endsection