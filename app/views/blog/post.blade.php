@extends('page')

@section('content')
	<div class="col-md-offset-1">
		<h1>
			<small>{{ $post->publish_date->format(Config::get('config.date_format')) }}</small>
			{{ $post->title }}
			{{ BlogController::editLink($post) }}
		</h1>
		@if (!empty($post->image->url))
		<figure class="{{ ($post->image->width > $post->image->height) ? 'landscape' : 'portrait' }}">
			<img src="{{ $post->image->url }}" width="{{ $post->image->width }}" height="{{ $post->image->height }}">
			@if (!empty($post->caption))
			<figcaption>{{ $post->caption }}</figcaption>
			@endif
		</figure>
		@endif				
		{{ $post->content }}
	</div>
@endsection

@section('side')
	<div class="wallpaper">
		<span>Recent posts</span>
		@foreach ($related as $post)
		<h3><a href="/blog/{{ $post->slug }}">{{ $post->title }}</a></h3>
		@endforeach
	</div>
@endsection