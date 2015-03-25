@if (count($publications))
	@foreach ($publications as $publication)
		<div class="col-md-6">
			<div class="publication">
				<div class="image" style="background-image:url({{ $publication->image->url }});"></div>
				<a href="{{ $publication->url }}">
					<div>
						{{ $publication->title }}
						@if ($publication->price !== null)
							<br>&ndash;<br>
							{{ App\Http\Controllers\Controller::formatPrice($publication->price) }}
						@endif
					</div>
				</a>
			</div>
		</div>
	@endforeach

@else
	<div class="alert alert-info indent">
		No publications matched the selected criteria.
	</div>
@endif