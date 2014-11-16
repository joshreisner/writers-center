@if (count($posts))
	@foreach ($posts as $post)

		<div class="post">
			<h1>
				<small>{{ $post->publish_date->format(Config::get('config.date_format')) }}</small>
				{{ link_to($post->url, $post->title) }}
			</h1>
			<div class="col-md-offset-1">
				<p>{{ $post->excerpt }}</p>
				<p class="more">{{ link_to($post->url, 'Read more&hellip;') }}</p>
			</div>
		</div>

	@endforeach

@else
	<div class="alert alert-info">
		No posts matched the selected criteria.
	</div>
@endif