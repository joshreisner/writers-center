@extends('page')

@section('content')

	<a class="label" href="/events">Events</a>

	<div class="col-md-offset-1">
		
		<h1>
			{{ $event->title }}
			{{ BaseController::editLink($event) }}
		</h1>
		
		{{ $event->description }}
		
		<dl>
			<dt>Date</dt>
			<dd>{{ $event->start->format('m/d/Y') }}</dd>

			<dt>Time</dt>
			<dd>{{ $event->start->format('g:i a') }}</dd>

			<dt>Price</dt>
			<dd>${{ $event->price }}</dd>
		</dl>

		<!--<a href="#" class="btn btn-primary">RSVP</a>-->

	</div>

@endsection

@section('side')
	<div class="wallpaper">
		<span class="label">Next Event</span>
		<h1>
			{{ $event->title }}
			<small>{{ $event->start->format('M d, Y g:i a') }}</small>
		</h1>
		<div class="description">
			{{ $event->description }}
		</div>
	</div>
@endsection