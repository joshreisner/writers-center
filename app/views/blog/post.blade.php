@extends('page')

@section('content')
	<a class="label" href="/blog">Blog</a>

	<div class="indent">
		
		<h1>
			<small>{{ $post->publish_date->format(Config::get('config.date_format')) }}</small>
			{{ $post->title }}
			{{ BaseController::editLink($post) }}
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
		
		@if (!empty($post->action_url))
		<a class="btn btn-primary" href="{{ $post->action_url }}">{{ $post->action or 'Click here' }}</a>
		@endif	

		<!--
		<dl>
			<dt>Tags</dt>
			<dd>
				@foreach ($post->tags as $tag)
				<div>{{ $tag->title }}</div>
				@endforeach
			</dd>
		</dl>
		-->

	</div>
@endsection

@section('side')
	<div class="wallpaper">
		<span class="label">Recent posts</span>
		@foreach ($related as $post)
		<h1>
			<small>{{ $post->publish_date->format(Config::get('config.date_format')) }}</small>
			<a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
		</h1>
		@endforeach
		<div class="image" style="background-image:url({{ $wallpaper}})"></div>
	</div>
@endsection