@if (count($months))
	@foreach ($months as $month=>$events)
		
		<h1 class="group">{{ $month }}</h1>
		
		@foreach ($events as $event)
		<div class="event">
			<div class="date">
				@if ($event->start->format('m/d') == $event->end->format('m/d'))
					{{ $event->start->format('m/d') }}<br>
					{{ $event->start->format('D') }}
				@else
					{{ $event->start->format('m/d') }}<br>
					through<br>
					{{ $event->end->format('m/d') }}
				@endif
			</div>
			<div class="description">
				<a class="title" href="{{ $event->url }}">{{ $event->title }}, {{ $event->start->format('g:i a') }}</a>
				{{ $event->description }}
			</div>
		</div>
		@endforeach

	@endforeach

@else
	<div class="alert alert-info indent">
		No events matched the selected criteria.
	</div>
@endif