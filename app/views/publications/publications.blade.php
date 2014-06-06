@foreach ($publications as $publication)
	<div class="publication col-md-6">
		<div class="inner" style="background-image:url({{ $publication->image->url }});">
			<a href="/publications/{{ $publication->slug }}">
				<div>
					{{ $publication->title }}<br>
					&ndash;<br>
					${{ $publication->price}}
				</div>
			</a>
		</div>
	</div>
@endforeach
