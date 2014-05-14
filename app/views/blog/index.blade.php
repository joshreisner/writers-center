@extends('blog.template')

@section('page')

	@foreach ($posts as $post)
	<div class="post">
		<h2><a href="/blog/{{ $post->slug }}">{{ $post->title }}</a></h2>
		<div class="date">Published: {{ $post->publish_date->format(Config::get('config.date_format')) }}</div>
		<div class="content">{{ $post->content }}</div>
	</div>
	@endforeach

@endsection