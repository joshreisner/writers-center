@extends('events.template')

@section('page')

	<h1>{{ $title }}</h1>

	<ul>
	@foreach ($events as $event)
		<li>
			<time>{{ $event->start->format('l, F j') }}</time> {{ $event->month }}
			<a href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">{{ $event->title }}</a>
			{{ $event->description }}
		</li>
	@endforeach
	</ul>

@endsection