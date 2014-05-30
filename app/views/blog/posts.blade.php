@foreach ($posts as $post)

	<div class="post">
		<h1>
			<small>{{ $post->publish_date->format(Config::get('config.date_format')) }}</small>
			<a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
		</h1>
		<p>{{ $post->excerpt }}</p>
	</div>

@endforeach
