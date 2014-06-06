@foreach ($months as $month=>$events)
	
	<h1 class="group">{{ $month }}</h1>
	
	@foreach ($events as $event)
	<div class="event row">
		<div class="col-md-1 date">
			{{ $event->start->format('m/y') }}<br>
			{{ $event->start->format('D') }}
		</div>
		<div class="col-md-11 description">
			<a class="title" href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">{{ $event->title }}, {{ $event->start->format('g:i a') }}</a>
			{{ $event->description }}
		</div>
	</div>
	@endforeach

@endforeach