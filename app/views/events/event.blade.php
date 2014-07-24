@extends('page')

@section('content')

	<a class="label" href="/events">Events</a>

	<div class="indent">
		
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

			@if ($event->price !== null)
			<dt>Price</dt>
			<dd>
				{{ BaseController::formatPrice($event->price) }}
			</dd>
			@endif
		</dl>

		<a href="{{ URL::action('PaymentController@add_event', $event->id) }}" class="btn btn-primary">Purchase Ticket</a>

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