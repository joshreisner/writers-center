@extends('page')

@section('content')

	<div class="col-md-offset-1">
		{{ $last_month = '' }}
		@foreach ($events as $event)
			@if ($event->month != $last_month)
				<h2>{{ $event->month }}</h2>
				<?php $last_month = $event->month ?>
			@endif
			<div class="event">
				<div class="date">{{ $event->start->format('l, F j') }}</div>
				<div class="description">
					<a href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">{{ $event->title }}</a>
					{{ $event->description }}
					<div class="meta">
						<div class="time">{{ $event->start->format('g:i a') }}</div>
						<div class="location">HVWC</div>
						<div class="price">{{ EventController::formatPrice($event) }}</div>
						<div class="button">
							<a href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">RSVP</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	
@endsection

@section('side')

	<form class="switchboard form-horizontal" data-model="events">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
		<div class="form-group">
			<label for="timeframe" class="col-md-3">Timeframe</label>
			<div class="col-md-9">
				{{ Form::dropdown('year', $years) }}
			</div>
		</div>
	</form>

@endsection