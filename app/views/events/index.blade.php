@extends('events.template')

@section('page')

	<h1>{{ $title }}</h1>

	<ul>
	@foreach ($events as $event)
		<li><a href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">{{ $event->title }}</a></li>
	@endforeach
	</ul>

@endsection