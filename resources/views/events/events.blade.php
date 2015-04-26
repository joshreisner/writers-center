@if (count($months))
	@foreach ($months as $month=>$events)
		
		<h3>{{ $month }}</h3>
		
		<ul class="events">
		@foreach ($events as $event)
			<li>
				<a class="title" href="{{ $event->url }}">{!! $event->title !!}</a>
				@if ($event->start->format('m/d') == $event->end->format('m/d'))
					{{-- single day --}}
					<em>{{ $event->start->format('D') }} {{ $event->start->format('m/d') }}, {{ $event->start->format('g:i a') }}</em>
				@else
					{{-- multi day --}}
					<em>{{ $event->start->format('m/d') }} through {{ $event->end->format('m/d') }}</em>
				@endif
				<p>{!! $event->excerpt !!}</p>
			</li>
		@endforeach
		</ul>
		
	@endforeach

@else
	<div class="alert alert-info indent">
		No events matched the selected criteria.
	</div>
@endif