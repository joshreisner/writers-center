@if (count($posts))
	@foreach ($posts as $post)

		<div class="post">
			<h1><a href="{{ $post->url }}">{!! $post->title !!}</a></h1>
			<small>{{ $post->publish_date->format(config('config.date_format')) }}</small>
			<p>{{ $post->excerpt }}</p>
			<p class="more">{!! link_to($post->url, 'Read more&hellip;') !!}</p>
		</div>

	@endforeach

@else
	<div class="alert alert-info">
		No posts matched the selected criteria.
	</div>
@endif