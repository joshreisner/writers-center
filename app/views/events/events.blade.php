@foreach ($months as $month=>$events)
	
	<h1 class="group">{{ $month }}</h1>
	
	@foreach ($events as $event)
	<div class="event">
		<div class="date">
			{{ $event->start->format('m/d') }}<br>
			{{ $event->start->format('D') }}
		</div>
		<div class="description">
			<a class="title" href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">{{ $event->title }}, {{ $event->start->format('g:i a') }}</a>
			{{ $event->description }}
		</div>
	</div>
	@endforeach

@endforeach