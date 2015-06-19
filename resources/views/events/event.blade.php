@extends('page')

@section('content')

	<a class="label" href="/events">Events</a>

	<div class="indent">
		
		<h1>
			{{ $event->title }}
			{!! App\Http\Controllers\Controller::editLink($event) !!}
		</h1>
		
		{!! $event->description !!}
		
		<dl>
			<dt>Date</dt>
			<dd>{{ App\Http\Controllers\EventController::formatDateRange($event->start, $event->end) }}</dd>

			<dt>Time</dt>
			<dd>{{ App\Http\Controllers\EventController::formatTimeRange($event->start, $event->end) }}</dd>

			@if ($event->price !== null)
			<dt>Price</dt>
			<dd>
				{{ App\Http\Controllers\Controller::formatPrice($event->price) }}
			</dd>
			@endif

			@if (App::environment('production'))
				@if (!empty($event->register_url))
					<dt><a class="btn btn-primary" href="{{ $event->register_url }}">Purchase Ticket</a></dt>
				@endif
			@else
				<dt>
				@if (Session::has('cart.events') && array_key_exists($event->id, Session::get('cart.events')))
					<a class="btn btn-disabled">Added to Cart</a>
				@else
					<a href="{{ URL::action('PaymentController@add_event', $event->id) }}" class="btn btn-primary">Purchase Ticket</a>
				@endif
				</dt>
			@endif
		</dl>

	</div>

@endsection

@section('side')
	<div class="wallpaper" style="background-image:url('{{ App\Http\Controllers\ImageController::wallpaper('events') }}');">
		<span class="label">Next Event</span>
		<h1>
			{{ $next->title }}
			<small>{{ $next->start->format('M d, Y g:i a') }}</small>
		</h1>
		<div class="description">
			{!! $next->description !!}
		</div>
	</div>
@endsection