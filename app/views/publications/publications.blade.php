@if (count($publications))
	@foreach ($publications as $publication)
		<div class="col-md-6">
			<div class="publication" style="background-image:url({{ $publication->image->url }});">
				<a href="{{ $publication->url }}">
					<div>
						{{ $publication->title }}
						@if ($publication->price !== null)
							<br>&ndash;<br>
							{{ BaseController::formatPrice($publication->price) }}
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